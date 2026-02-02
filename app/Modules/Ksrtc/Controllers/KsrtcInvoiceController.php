<?php

namespace App\Modules\Ksrtc\Controllers;

use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Modules\Ksrtc\Models\KsrtcCmcPeriod;
use App\Modules\Ksrtc\Models\KsrtcCmcInvoice;
use App\Modules\Vehicle\Models\Vehicle;

class KsrtcInvoiceController extends Controller{
    
    private function ksrtcEnsurePeriodsExist($clientId = 1778){
        $start = Carbon::create(2021, 9, 1)->startOfMonth();

        // HARD STOP: only create periods with start <= 2025-08-01
        $maxStart = Carbon::create(2025, 8, 1)->startOfMonth();

        $periodStart = $start->copy();

        while ($periodStart->lte($maxStart)) {

            $periodEnd = $periodStart->copy()->addMonths(6)->subDay();

            $title = $periodStart->format('M Y') . ' - ' . $periodEnd->format('M Y');

            KsrtcCmcPeriod::firstOrCreate(
                [
                    'client_id'     => $clientId,
                    'period_start'  => $periodStart->toDateString(),
                ],
                [ 
                    'period_end'    => $periodEnd->toDateString(),
                    'title'         => $title,
                ]
            );
    
            $periodStart->addMonth();
            }
    }
    private function ksrtcInstallCounts($clientId = 1778){
        return Vehicle::query()
            ->where('client_id', $clientId)
            ->whereNotNull('installation_date')
            ->selectRaw("DATE_FORMAT(installation_date, '%Y-%m') as ym")
            ->selectRaw("COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();
    }
    private function ksrtcCmcEligibleCountRolling(array $installCounts, Carbon $periodStart){
        $count = 0;

        $cursor = $periodStart->copy()->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();

        // Exclude installations within first 2 years before the period start
        // Use endOfMonth so whole installation month two years prior is chargeable
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        while ($cursor->gte($min)) {
            // skip months that are within the 2-year free window
            if ($cursor->gt($threshold)) {
                $cursor->subMonths(6);
                continue;
            }

            $ym = $cursor->format('Y-m');

            if (isset($installCounts[$ym])) {
                $count += (int) $installCounts[$ym];
            }

            $cursor->subMonths(6);
        }

        return $count;
    }

    public function cmcReportRoot(Request $request){


        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!$user->root) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        $this->ksrtcEnsurePeriodsExist($clientId);

        $installCounts = $this->ksrtcInstallCounts($clientId);

        $periods = KsrtcCmcPeriod::where('client_id', $clientId)
            ->with('invoices')
            ->orderBy('period_start', 'desc')
            ->get();

        // attach computed counts + totals
        $rate = 708;

        foreach ($periods as $p) {
            $pStart = Carbon::parse($p->period_start);
        
            $p->eligible_count = $this->ksrtcCmcEligibleCountRolling($installCounts, $pStart);
            $p->expected_total = $p->eligible_count * $rate;
        
            $p->invoice_total = $p->invoices->sum('amount');
        
            // NEW: total device count billed in invoices for that period
            $p->invoice_device_count = $p->invoices->sum('device_count');
        }


        return view('ksrtc.cmc-root-report', compact('periods'));
    }
    public function cmcReportClient(Request $request){
        $user = Auth::user();
        if (!$user || !$user->client) {
            abort(403, 'Unauthorized');
        }

        $clientId = $user->client->id;

        if ((int)$clientId !== 1778) {
            abort(403, 'Access denied');
        }

        $periods = KsrtcCmcPeriod::where('client_id', 1778)
            ->with('invoices')
            ->orderBy('period_start', 'desc')
            ->get();

        foreach ($periods as $p) {
            $p->invoice_total = $p->invoices->sum('amount');
        }

        return view('ksrtc.cmc-client-report', compact('periods'));
    }
    public function cmcInvoiceUpload(Request $request){
        $user = Auth::user();
        if (!$user || !$user->hasRole('root')) {
            abort(403, 'Access denied');
        }

        $request->validate([
            'period_id' => 'required|exists:abc_ksrtc_cmc_periods,id',
            'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:10240',
            'invoice_no' => 'nullable|string|max:191',
            'invoice_date' => 'nullable|date',
            'amount' => 'required|numeric|min:0',
            'device_count' => 'required|integer|min:0',  
        ]);

        $period = KsrtcCmcPeriod::findOrFail($request->period_id);

        // folder
        $folder = public_path('uploads/ksrtc/cmc');
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $file = $request->file('invoice_file');
        $originalName = $file->getClientOriginalName();

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($folder, $fileName);

        $path = 'uploads/ksrtc/cmc/' . $fileName;

        KsrtcCmcInvoice::create([
            'period_id' => $period->id,
            'invoice_no' => $request->invoice_no,
            'invoice_date' => $request->invoice_date,
            'amount' => $request->amount,
            'device_count' => $request->device_count,
            'file_path' => $path,
            'original_name' => $originalName,
        ]);


        return redirect()->back()->with('success', 'Invoice uploaded successfully');
    }
    public function cmcInvoiceDownload($id){
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $invoice = KsrtcCmcInvoice::with('period')->findOrFail($id);

        // allow root OR client 1778
        $allowed = false;

        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778 && (int)$invoice->period->client_id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $fullPath = public_path($invoice->file_path);

        if (!file_exists($fullPath)) {
            abort(404, 'File not found');
        }

        return response()->download($fullPath, $invoice->original_name);
    }
    public function cmcInvoiceDelete($id){
        $user = Auth::user();
        if (!$user || !$user->hasRole('root')) {
            abort(403, 'Access denied');
        }


        $invoice = KsrtcCmcInvoice::findOrFail($id);

        $fullPath = public_path($invoice->file_path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }

        $invoice->delete();

        return redirect()->back()->with('success', 'Invoice deleted successfully');
    }

    // New: devices page showing devices per period
    public function devicesPage(Request $request){
        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        $this->ksrtcEnsurePeriodsExist($clientId);

        $periods = KsrtcCmcPeriod::where('client_id', $clientId)
            ->orderBy('period_start', 'desc')
            ->get();

        return view()->file(base_path('app/Modules/Ksrtc/Views/devices.blade.php'), compact('periods'));
    }
    public function devicesList(Request $request){
        $request->validate([
            'period_id' => 'required|exists:abc_ksrtc_cmc_periods,id',
        ]);

        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $period = KsrtcCmcPeriod::findOrFail($request->period_id);

        $periodStart = Carbon::parse($period->period_start)->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();

        $yms = [];
        $cursor = $periodStart->copy();
        while ($cursor->gte($min)) {
            $yms[] = $cursor->format('Y-m');
            $cursor->subMonths(6);
        }

        // Exclude installations that are within first 2 years (CMC free for 2 years)
        // Use endOfMonth so the entire installation month two years prior is included
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        $q = \DB::table('vehicles')
            ->join('gps_summery as gps', 'vehicles.gps_id', '=', 'gps.id')
            ->where('vehicles.client_id', 1778)
            ->whereNull('vehicles.deleted_at')
            ->whereNotNull('vehicles.installation_date')
            // only include vehicles installed in the target months AND older than 2 years
            ->whereIn(\DB::raw("DATE_FORMAT(vehicles.installation_date, '%Y-%m')"), $yms)
            ->where('vehicles.installation_date', '<=', $threshold->toDateTimeString())
            ->select('vehicles.id as vehicle_id', 'vehicles.register_number as vehicle_no', 'gps.imei', 'vehicles.installation_date');

        $dt = DataTables::of($q)
            ->addIndexColumn()
            // Map DataTables search to real DB columns to avoid unknown column errors
            ->filterColumn('vehicle_no', function ($query, $keyword) {
                $query->where('vehicles.register_number', 'like', "%{$keyword}%");
            })
            ->filterColumn('imei', function ($query, $keyword) {
                $query->where('gps.imei', 'like', "%{$keyword}%");
            })
            ->filterColumn('installation_date', function ($query, $keyword) {
                $query->where('vehicles.installation_date', 'like', "%{$keyword}%");
            })
            ->editColumn('installation_date', function ($row) {
                return Carbon::parse($row->installation_date)->format('Y-m-d');
            });

        return $dt->make(true);
    }
    public function devicesSummary(Request $request){
        $request->validate([
            'period_id' => 'required|exists:abc_ksrtc_cmc_periods,id',
        ]);

        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $period = KsrtcCmcPeriod::findOrFail($request->period_id);

        $periodStart = Carbon::parse($period->period_start)->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();

        $yms = [];
        $cursor = $periodStart->copy();
        while ($cursor->gte($min)) {
            $yms[] = $cursor->format('Y-m');
            $cursor->subMonths(6);
        }
        // Exclude installations that are within first 2 years (CMC free for 2 years)
        // Use endOfMonth so the entire installation month two years prior is included
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        $count = \DB::table('vehicles')
            ->join('gps_summery as gps', 'vehicles.gps_id', '=', 'gps.id')
            ->where('vehicles.client_id', 1778)
            ->whereNull('vehicles.deleted_at')
            ->whereNotNull('vehicles.installation_date')
            // only include vehicles installed in the target months AND older than 2 years
            ->whereIn(\DB::raw("DATE_FORMAT(vehicles.installation_date, '%Y-%m')"), $yms)
            ->where('vehicles.installation_date', '<=', $threshold->toDateTimeString())
            ->count();

        $rate = 708;
        $amount = $count * $rate;

        return response()->json([
            'period_id' => $period->id,
            'title' => $period->title ?? (Carbon::parse($period->period_start)->format('M Y')),
            'count' => $count,
            'rate' => $rate,
            'amount' => $amount,
        ]);
    }
    public function devicesExport(Request $request){
        $request->validate([
            'period_id' => 'required|exists:abc_ksrtc_cmc_periods,id',
        ]);

        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $period = KsrtcCmcPeriod::findOrFail($request->period_id);

        $periodStart = Carbon::parse($period->period_start)->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();

        $yms = [];
        $cursor = $periodStart->copy();
        while ($cursor->gte($min)) {
            $yms[] = $cursor->format('Y-m');
            $cursor->subMonths(6);
        }

        // Exclude installations that are within first 2 years (CMC free for 2 years)
        // Use endOfMonth so the entire installation month two years prior is included
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        $rows = \DB::table('vehicles')
            ->join('gps_summery as gps', 'vehicles.gps_id', '=', 'gps.id')
            ->where('vehicles.client_id', 1778)
            ->whereNull('vehicles.deleted_at')
            ->whereNotNull('vehicles.installation_date')
            // only include vehicles installed in the target months AND older than 2 years
            ->whereIn(\DB::raw("DATE_FORMAT(vehicles.installation_date, '%Y-%m')"), $yms)
            ->where('vehicles.installation_date', '<=', $threshold->toDateTimeString())
            ->select('vehicles.register_number as vehicle_no', 'gps.imei', 'vehicles.installation_date')
            ->orderBy('vehicles.register_number')
            ->get();

        $filename = 'ksrtc_devices_' . $period->id . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($rows) {
            // Clear any output buffering to avoid stray blank lines
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

            $out = fopen('php://output', 'w');
            // Header row
            fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);
            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date]);
            }
            fclose($out);
        }, 200, $headers);
    }

    // Bulk export: create one CSV per period (title in first row, headings in second,
    // data from third row), zip them and return the zip file for download.
    public function devicesExportAll(Request $request){
        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $periods = KsrtcCmcPeriod::where('client_id', 1778)->orderBy('period_start', 'desc')->get();

        $periodsList = $periods;

        $filename = 'ksrtc_periods_all_' . date('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($periodsList) {
            // Clear any output buffering
            while (ob_get_level() > 0) { ob_end_clean(); }

            $out = fopen('php://output', 'w');

            foreach ($periodsList as $period) {
                $periodStart = Carbon::parse($period->period_start)->startOfMonth();
                $min = Carbon::create(2021, 9, 1)->startOfMonth();

                $yms = [];
                $cursor = $periodStart->copy();
                while ($cursor->gte($min)) {
                    $yms[] = $cursor->format('Y-m');
                    $cursor->subMonths(6);
                }

                // Exclude installations within first 2 years for this period
                // Use endOfMonth so the entire installation month two years prior is included
                $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

                $rows = \DB::table('vehicles')
                    ->join('gps_summery as gps', 'vehicles.gps_id', '=', 'gps.id')
                    ->where('vehicles.client_id', 1778)
                    ->whereNull('vehicles.deleted_at')
                    ->whereNotNull('vehicles.installation_date')
                    ->whereIn(\DB::raw("DATE_FORMAT(vehicles.installation_date, '%Y-%m')"), $yms)
                    ->where('vehicles.installation_date', '<=', $threshold->toDateTimeString())
                    ->select('vehicles.register_number as vehicle_no', 'gps.imei', 'vehicles.installation_date')
                    ->orderBy('vehicles.register_number')
                    ->get();

                // Period title row
                fputcsv($out, [ $period->title ?? Carbon::parse($period->period_start)->format('M Y') ]);
                // Headings row
                fputcsv($out, ['SL No','Vehicle No','IMEI','Installed At']);

                $i = 1;
                foreach ($rows as $r) {
                    $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                    fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date]);
                }

                // blank separator row between periods
                fputcsv($out, []);
            }

            fclose($out);
        }, 200, $headers);
    }

    // Create one CSV per period and return a ZIP containing all files.
    // Attempts ZipArchive, falls back to system 'zip' command if available.
    public function devicesExportMultiple(Request $request){
        $user = Auth::user();
        $allowed = false;
        if ($user) {
            if ($user->root) {
                $allowed = true;
            } elseif ($user->client && (int)$user->client->id === 1778) {
                $allowed = true;
            }
        }
        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $periods = KsrtcCmcPeriod::where('client_id', 1778)->orderBy('period_start', 'desc')->get();

        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ksrtc_export_' . uniqid();
        if (!mkdir($tmpDir) && !is_dir($tmpDir)) {
            abort(500, 'Could not create temp directory');
        }

        $files = [];

        foreach ($periods as $period) {
            $periodStart = Carbon::parse($period->period_start)->startOfMonth();
            $min = Carbon::create(2021, 9, 1)->startOfMonth();

            $yms = [];
            $cursor = $periodStart->copy();
            while ($cursor->gte($min)) {
                $yms[] = $cursor->format('Y-m');
                $cursor->subMonths(6);
            }

            // Exclude installations within first 2 years for this period
            // Use endOfMonth so the entire installation month two years prior is included
            $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

            $rows = \DB::table('vehicles')
                ->join('gps_summery as gps', 'vehicles.gps_id', '=', 'gps.id')
                ->where('vehicles.client_id', 1778)
                ->whereNull('vehicles.deleted_at')
                ->whereNotNull('vehicles.installation_date')
                ->whereIn(\DB::raw("DATE_FORMAT(vehicles.installation_date, '%Y-%m')"), $yms)
                ->where('vehicles.installation_date', '<=', $threshold->toDateTimeString())
                ->select('vehicles.register_number as vehicle_no', 'gps.imei', 'vehicles.installation_date')
                ->orderBy('vehicles.register_number')
                ->get();

            $cleanTitle = preg_replace('/[^A-Za-z0-9]+/', '_', trim($period->title ?? 'period_'.$period->id));
            $fileName = $period->id . '_' . $cleanTitle . '.csv';
            $filePath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

            $fh = fopen($filePath, 'w');
            if ($fh === false) continue;

            // First row: period title
            fputcsv($fh, [ $period->title ?? Carbon::parse($period->period_start)->format('M Y') ]);
            // Second row: headings
            fputcsv($fh, ['SL No','Vehicle No','IMEI','Installed At']);

            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($fh, [$i++, $r->vehicle_no, $r->imei, $date]);
            }

            fclose($fh);

            $files[] = [$filePath, $fileName];
        }

        if (empty($files)) {
            // cleanup
            @rmdir($tmpDir);
            return redirect()->back()->with('error', 'No files to export');
        }

        $zipPath = $tmpDir . DIRECTORY_SEPARATOR . 'ksrtc_periods_' . date('Ymd_His') . '.zip';

        // Try ZipArchive first
        if (class_exists('\ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                foreach ($files as $f) {
                    $zip->addFile($f[0], $f[1]);
                }
                $zip->close();
            } else {
                $zipPath = null;
            }
        }

        // Fallback: try system `zip` command if ZipArchive not available
        if (!file_exists($zipPath)) {
            $zipCmd = null;
            // build list of file paths safely
            $cmdFiles = array_map(function($f){ return escapeshellarg($f[0]); }, $files);
            $cmd = 'zip -j ' . escapeshellarg($zipPath) . ' ' . implode(' ', $cmdFiles) . ' 2>&1';
            $returnVar = null;
            @exec('command -v zip', $out, $returnVar);
            if ($returnVar === 0) {
                @exec($cmd, $out2, $rc);
                if (!file_exists($zipPath) || $rc !== 0) {
                    $zipPath = null;
                }
            } else {
                $zipPath = null;
            }
        }

        if ($zipPath && file_exists($zipPath)) {
            // cleanup CSVs after sending
            $response = response()->download($zipPath, basename($zipPath))->deleteFileAfterSend(true);
            // schedule cleanup of temp csv files after response sent
            // PHP will remove file after send; remove temp dir if empty
            foreach ($files as $f) { @unlink($f[0]); }
            @rmdir($tmpDir);
            return $response;
        }

        // If we reach here, cannot create zip; provide fallback: stream single combined CSV (as existing devicesExportAll)
        $filename = 'ksrtc_periods_all_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function() use ($files, $periods) {
            while (ob_get_level() > 0) { ob_end_clean(); }
            $out = fopen('php://output', 'w');
            foreach ($periods as $period) {
                $periodPath = preg_replace('/[^A-Za-z0-9]+/', '_', trim($period->title ?? 'period_'.$period->id));
                // find matching file
                $match = null;
                foreach ($files as $f) { if (strpos($f[1], (string)$period->id . '_') === 0) { $match = $f[0]; break; } }
                if ($match && file_exists($match)) {
                    // write contents with a separator
                    fputcsv($out, [ $period->title ?? Carbon::parse($period->period_start)->format('M Y') ]);
                    // copy file contents skipping nothing (they already contain header rows)
                    $fh = fopen($match, 'r');
                    while (($line = fgets($fh)) !== false) {
                        fwrite($out, $line);
                    }
                    fclose($fh);
                    fputcsv($out, []);
                }
            }
            fclose($out);
        }, 200, $headers);
    }

}
