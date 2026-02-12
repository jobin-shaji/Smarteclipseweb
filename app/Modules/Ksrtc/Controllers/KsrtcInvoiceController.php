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
use App\Modules\Gps\Models\Gps;
use App\Modules\Servicer\Models\ServiceIn;

class KsrtcInvoiceController extends Controller
{

    private function ksrtcEnsurePeriodsExist($clientId = 1778)
    {
        $start = Carbon::create(2023, 8, 1)->startOfMonth();

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
    private function ksrtcInstallCounts($clientId = 1778)
    {
        return Vehicle::query()
            ->where('client_id', $clientId)
            ->whereNotNull('installation_date')
            ->selectRaw("DATE_FORMAT(installation_date, '%Y-%m') as ym")
            ->selectRaw("COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();
    }
    private function ksrtcCmcEligibleCountRolling(array $installCounts, Carbon $periodStart)
    {
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

    private function ksrtcCmcEligibleWithCertificateCountRolling($clientId, Carbon $periodStart)
    {
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

            // Count vehicles installed in this month with certificates
            $monthCount = (int) DB::table('vehicles as v')
                ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
                ->where('v.client_id', $clientId)
                ->whereNull('v.deleted_at')
                ->whereNotNull('v.installation_date')
                ->whereRaw("DATE_FORMAT(v.installation_date, '%Y-%m') = ?", [$ym])
                ->whereNotNull('g.warrenty_certificate')
                ->where('g.warrenty_certificate', '!=', '')
                ->count();

            $count += $monthCount;

            $cursor->subMonths(6);
        }

        return $count;
    }

    public function cmcReportRoot(Request $request)
    {


        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if (!$user->root) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Selected year for optional filtering (defaults to current year)
        $selectedYear = (int) ($request->query('year') ?? date('Y'));

        // Selected year for V3 (optional GET param)
        $selectedYear = (int) ($request->query('year') ?? date('Y'));

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
    public function cmcReportClient(Request $request)
    {
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
    public function cmcInvoiceUpload(Request $request)
    {
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
    public function cmcInvoiceDownload($id)
    {
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
    public function cmcInvoiceDelete($id)
    {
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
    public function devicesPage(Request $request)
    {
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
    public function devicesList(Request $request)
    {
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

        $clientId = 1778;

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
    public function devicesSummary(Request $request)
    {
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
        $invoices = KsrtcCmcInvoice::where('period_id', $period->id)
            ->orderBy('id')
            ->get(['id', 'original_name'])
            ->map(function ($inv) {
                return [
                    'id' => $inv->id,
                    'name' => $inv->original_name,
                    'url' => route('ksrtc.cmc.invoice.download', $inv->id),
                ];
            })->values();

        return response()->json([
            'period_id' => $period->id,
            'title' => $period->title ?? (Carbon::parse($period->period_start)->format('M Y')),
            'count' => $count,
            'rate' => $rate,
            'amount' => $amount,
            'invoices' => $invoices,
        ]);
    }
    public function devicesExport(Request $request)
    {
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

        return response()->stream(function () use ($rows) {
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
    public function devicesExportAll(Request $request)
    {
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

        return response()->stream(function () use ($periodsList) {
            // Clear any output buffering
            while (ob_get_level() > 0) {
                ob_end_clean();
            }

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
                fputcsv($out, [$period->title ?? Carbon::parse($period->period_start)->format('M Y')]);
                // Headings row
                fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);

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
    public function devicesExportMultiple(Request $request)
    {
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

            $cleanTitle = preg_replace('/[^A-Za-z0-9]+/', '_', trim($period->title ?? 'period_' . $period->id));
            $fileName = $period->id . '_' . $cleanTitle . '.csv';
            $filePath = $tmpDir . DIRECTORY_SEPARATOR . $fileName;

            $fh = fopen($filePath, 'w');
            if ($fh === false) continue;

            // First row: period title
            fputcsv($fh, [$period->title ?? Carbon::parse($period->period_start)->format('M Y')]);
            // Second row: headings
            fputcsv($fh, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);

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
            $cmdFiles = array_map(function ($f) {
                return escapeshellarg($f[0]);
            }, $files);
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
            foreach ($files as $f) {
                @unlink($f[0]);
            }
            @rmdir($tmpDir);
            return $response;
        }

        // If we reach here, cannot create zip; provide fallback: stream single combined CSV (as existing devicesExportAll)
        $filename = 'ksrtc_periods_all_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($files, $periods) {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
            $out = fopen('php://output', 'w');
            foreach ($periods as $period) {
                $periodPath = preg_replace('/[^A-Za-z0-9]+/', '_', trim($period->title ?? 'period_' . $period->id));
                // find matching file
                $match = null;
                foreach ($files as $f) {
                    if (strpos($f[1], (string)$period->id . '_') === 0) {
                        $match = $f[0];
                        break;
                    }
                }
                if ($match && file_exists($match)) {
                    // write contents with a separator
                    fputcsv($out, [$period->title ?? Carbon::parse($period->period_start)->format('M Y')]);
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

    /**
     * Download Excel and all bills for ALL periods - each period in its own folder, all in one ZIP
     */
    public function downloadPeriodBills(Request $request)
    {
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

        // Get all periods with their invoices
        $periods = KsrtcCmcPeriod::where('client_id', 1778)
            ->with('invoices')
            ->orderBy('period_start', 'desc')
            ->get();

        if ($periods->isEmpty()) {
            return redirect()->back()->with('error', 'No periods found');
        }

        // Create main temp directory
        $tmpDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'ksrtc_all_periods_' . uniqid();
        if (!mkdir($tmpDir) && !is_dir($tmpDir)) {
            abort(500, 'Could not create temp directory');
        }

        $allFiles = [];
        $periodFolders = [];

        // Process each period
        foreach ($periods as $period) {
            // Create folder name from period title
            $cleanTitle = preg_replace('/[^A-Za-z0-9]+/', '_', trim($period->title ?? 'period_' . $period->id));
            $folderName = $cleanTitle;

            // Create period folder
            $periodFolder = $tmpDir . DIRECTORY_SEPARATOR . $folderName;
            if (!mkdir($periodFolder) && !is_dir($periodFolder)) {
                continue; // Skip this period if folder creation fails
            }
            $periodFolders[] = $periodFolder;

            // 1. Generate Excel/CSV file with devices for this period
            $periodStart = Carbon::parse($period->period_start)->startOfMonth();
            $min = Carbon::create(2021, 9, 1)->startOfMonth();

            $yms = [];
            $cursor = $periodStart->copy();
            while ($cursor->gte($min)) {
                $yms[] = $cursor->format('Y-m');
                $cursor->subMonths(6);
            }

            // Exclude installations within first 2 years for this period
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

            // Create CSV file for devices
            $csvFileName = 'devices.csv';
            $csvFilePath = $periodFolder . DIRECTORY_SEPARATOR . $csvFileName;

            $fh = fopen($csvFilePath, 'w');
            if ($fh !== false) {
                // First row: period title
                fputcsv($fh, [$period->title ?? Carbon::parse($period->period_start)->format('M Y')]);
                // Second row: headings
                fputcsv($fh, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);

                $i = 1;
                foreach ($rows as $r) {
                    $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                    fputcsv($fh, [$i++, $r->vehicle_no, $r->imei, $date]);
                }

                fclose($fh);
                $allFiles[] = $csvFilePath;
            }

            // 2. Copy all invoice/bill files for this period
            foreach ($period->invoices as $invoice) {
                $sourcePath = public_path($invoice->file_path);

                if (file_exists($sourcePath)) {
                    // Get file extension
                    $extension = pathinfo($sourcePath, PATHINFO_EXTENSION);
                    // Create a clean filename
                    $billFileName = 'bill_' . $invoice->id . '_' .
                        preg_replace('/[^A-Za-z0-9._-]/', '_', $invoice->original_name ?? ('invoice_' . $invoice->id . '.' . $extension));

                    $destPath = $periodFolder . DIRECTORY_SEPARATOR . $billFileName;

                    // Copy the file
                    if (copy($sourcePath, $destPath)) {
                        $allFiles[] = $destPath;
                    }
                }
            }
        }

        if (empty($allFiles)) {
            // cleanup
            foreach ($periodFolders as $folder) {
                @rmdir($folder);
            }
            @rmdir($tmpDir);
            return redirect()->back()->with('error', 'No files to download');
        }

        // Create ZIP file containing all period folders
        $zipFileName = 'KSRTC_All_Periods_' . date('Ymd_His') . '.zip';
        $zipPath = $tmpDir . DIRECTORY_SEPARATOR . $zipFileName;

        $zipCreated = false;

        // Try ZipArchive first
        if (class_exists('\ZipArchive')) {
            $zip = new \ZipArchive();
            if ($zip->open($zipPath, \ZipArchive::CREATE) === true) {
                foreach ($allFiles as $filePath) {
                    // Calculate relative path from tmpDir
                    $relativePath = str_replace($tmpDir . DIRECTORY_SEPARATOR, '', $filePath);
                    $zip->addFile($filePath, $relativePath);
                }
                $zip->close();
                $zipCreated = true;
            }
        }

        // Fallback: try system `zip` command if ZipArchive not available
        if (!$zipCreated) {
            $returnVar = null;
            @exec('command -v zip', $out, $returnVar);
            if ($returnVar === 0) {
                // Change to temp directory and create zip
                $oldCwd = getcwd();
                chdir($tmpDir);

                // Get all folder names
                $folderNames = array_map('basename', $periodFolders);
                $foldersArg = implode(' ', array_map('escapeshellarg', $folderNames));

                $cmd = 'zip -r ' . escapeshellarg($zipFileName) . ' ' . $foldersArg . ' 2>&1';
                @exec($cmd, $out2, $rc);

                chdir($oldCwd);

                if (file_exists($zipPath) && $rc === 0) {
                    $zipCreated = true;
                }
            }
        }

        if ($zipCreated && file_exists($zipPath)) {
            // Download and cleanup
            $response = response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);

            // Schedule cleanup of all temp files
            foreach ($allFiles as $f) {
                @unlink($f);
            }
            foreach ($periodFolders as $folder) {
                @rmdir($folder);
            }
            @rmdir($tmpDir);

            return $response;
        }

        // If ZIP creation failed, cleanup and return error
        foreach ($allFiles as $f) {
            @unlink($f);
        }
        foreach ($periodFolders as $folder) {
            @rmdir($folder);
        }
        @rmdir($tmpDir);

        return redirect()->back()->with('error', 'Could not create ZIP file. Please contact administrator.');
    }

    /**
     * Client Renewal Report V2 (AJAX version)
     * Shows renewal report page with AJAX data loading and year selection
     */
    public function clientrenewalreport2(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        // Just return the view - data will be loaded via AJAX
        return view('Ksrtc::client-renewal-report2');
    }

    /**
     * Client Renewal Report V2 - AJAX Data Endpoint
     * Returns JSON data for the renewal report based on selected year
     */
    public function clientrenewalreportData(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            return response()->json(['error' => 'Access denied'], 403);
        }

        $clientId = 1778;

        // Get selected year from request, default to current year
        $selectedYear = (int) ($request->query('year') ?? date('Y'));

        // Validate year
        if ($selectedYear < 2021 || $selectedYear > 2026) {
            $selectedYear = (int) date('Y');
        }

        // ---------------------------
        // 1) FIRST ARRAY: Month-wise install counts (Jan-Dec) FILTERED BY SELECTED YEAR
        // ---------------------------
        $installsByMonth = Vehicle::query()
            ->where('client_id', $clientId)
            ->whereNull('deleted_at')
            ->whereNotNull('installation_date')
            ->whereYear('installation_date', $selectedYear)
            ->selectRaw('MONTH(installation_date) as month_no')
            ->selectRaw('COUNT(*) as cnt')
            ->groupBy('month_no')
            ->pluck('cnt', 'month_no')
            ->toArray();

        $installMonths = [];
        for ($m = 1; $m <= 12; $m++) {
            $installMonths[] = [
                'month_no' => $m,
                'month_name' => Carbon::createFromDate(2000, $m, 1)->format('M'),
                'installed_count' => $installsByMonth[$m] ?? 0,
            ];
        }

        // ---------------------------
        // 2) Get all installation counts by Y-m format for CMC calculations
        // ---------------------------
        $installCounts = Vehicle::query()
            ->where('client_id', $clientId)
            ->whereNull('deleted_at')
            ->whereNotNull('installation_date')
            ->selectRaw("DATE_FORMAT(installation_date, '%Y-%m') as ym")
            ->selectRaw("COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();

        // ---------------------------
        // 3) Get renewed counts by Y-m format (pay_status = 1)
        // ---------------------------
        $renewedCounts = Vehicle::query()
            ->where('vehicles.client_id', $clientId)
            ->whereNull('vehicles.deleted_at')
            ->whereNotNull('vehicles.installation_date')
            ->join('gps_summery', 'gps_summery.id', '=', 'vehicles.gps_id')
            ->where('gps_summery.pay_status', 1)
            ->selectRaw("DATE_FORMAT(vehicles.installation_date, '%Y-%m') as ym")
            ->selectRaw("COUNT(vehicles.id) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();

        // ---------------------------
        // 4) Get service visits by month (calendar month 1-12) FILTERED BY SELECTED YEAR
        // ---------------------------
        $serviceVisitsByMonth = ServiceIn::query()
            ->from('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->where('v.client_id', $clientId)
            ->whereYear('si.date', $selectedYear)
            ->selectRaw('MONTH(si.date) as month_no')
            ->selectRaw('COUNT(si.id) as cnt')
            ->groupBy('month_no')
            ->pluck('cnt', 'month_no')
            ->toArray();

        // ---------------------------
        // 5) SECOND ARRAY: 12 billing periods - START FROM END OF SELECTED YEAR
        // For selected year, start from December of that year and go backwards 12 months
        // ---------------------------
        $billingPeriods = [];

        // Start from the last month of the selected year (December)
        $periodStart = Carbon::create($selectedYear, 12, 1)->endOfMonth()->startOfMonth();

        for ($i = 0; $i < 12; $i++) {
            // Title: "Dec 23" format (short month + year)
            $title = $periodStart->format('M y');

            // Get calendar month number (1-12) for this period
            $monthNo = (int)$periodStart->format('n');

            // Get installed count for this calendar month (from selected year)
            $installedCount = $installsByMonth[$monthNo] ?? 0;

            // Calculate CMC eligible count using rolling 6-month logic
            $eligibleCount = $this->ksrtcCmcEligibleCountRolling($installCounts, $periodStart);

            // Calculate renewed count for this period (using same rolling logic)
            $renewedCount = $this->ksrtcCmcEligibleCountRolling($renewedCounts, $periodStart);

            // Get service visits for this calendar month
            $serviceVisits = $serviceVisitsByMonth[$monthNo] ?? 0;

            // Get certificate count for CMC eligible vehicles (same rolling logic as renewal_needed)
            $certificateCount = $this->ksrtcCmcEligibleWithCertificateCountRolling($clientId, $periodStart);

            $billingPeriods[] = [
                'title' => $title,
                'installed_count' => $installedCount,
                'renewal_needed' => $eligibleCount,
                'renewed' => $renewedCount,
                'not_renewed' => max(0, $eligibleCount - $renewedCount),
                'service_visits' => $serviceVisits,
                'certificate_count' => $certificateCount,
                'amount' => $eligibleCount * 708, // Rs. 708 per device
            ];

            // Move to previous month (going backwards)
            $periodStart->subMonth();
        }

        // ---------------------------
        // 6) Total service visits for display - ALL TIME (NOT filtered by selected year)
        // ---------------------------
        $totalservicevisits = (int) ServiceIn::query()
            ->from('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->where('v.client_id', $clientId)
            ->count();

        // ---------------------------
        // 7) Total statistics - ALL TIME (NOT filtered by selected year)
        // ---------------------------
        try {
            // Total installations across all years
            $total_installed_alltime = (int) Vehicle::query()
                ->where('client_id', $clientId)
                ->whereNull('deleted_at')
                ->whereNotNull('installation_date')
                ->count();

            // Not Renewed: count ALL vehicles for client where gps.pay_status = 0
            $not_renewed_sum = (int) DB::table('vehicles as v')
                ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
                ->where('v.client_id', $clientId)
                ->whereNull('v.deleted_at')
                ->whereNotNull('v.installation_date')
                ->where('g.pay_status', 0)
                ->count();

            // Replaced by uni140: total count
            $replaced_uni140_count = (int) DB::table('abc_temp_ksrtc_add_data')
                ->selectRaw('COALESCE(SUM(replaced_by_uni140),0) as c')
                ->value('c');

            // Data certificate attached: ALL vehicles with certificate
            $certificate_count = (int) DB::table('vehicles as v')
                ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
                ->where('v.client_id', $clientId)
                ->whereNull('v.deleted_at')
                ->whereNotNull('g.warrenty_certificate')
                ->where('g.warrenty_certificate', '!=', '')
                ->count();

            // Not Paid: count vehicles NOT present in abc_ksrtc_amount_given table with paid_status = 1
            $not_paid_count = (int) Vehicle::query()
                ->where('client_id', $clientId)
                ->whereNull('deleted_at')
                ->whereNotNull('installation_date')
                ->whereNotIn('id', function ($query) {
                    $query->select('vehicles_id')
                        ->from('abc_ksrtc_amount_given')
                        ->where('paid_status', 1);
                })
                ->count();

            $additionalStats = [
                'data_recharged' => $total_installed_alltime,
                'not_renewed' => $not_renewed_sum,
                'imei_untagged' => 0,
                'replaced_by_uni140' => $replaced_uni140_count,
                'data_certificate_attached' => $certificate_count,
                'not_paid' => $not_paid_count,
            ];
        } catch (\Exception $e) {
            $additionalStats = [
                'data_recharged' => array_sum(array_column($installMonths, 'installed_count')),
                'not_renewed' => array_sum(array_column($billingPeriods, 'not_renewed')),
                'imei_untagged' => 0,
                'replaced_by_uni140' => 0,
                'data_certificate_attached' => 0,
                'not_paid' => 0,
            ];
        }

        // Return JSON response
        return response()->json([
            'success' => true,
            'year' => $selectedYear,
            'installMonths' => $installMonths,
            'billingPeriods' => $billingPeriods,
            'totalservicevisits' => $totalservicevisits,
            'additionalStats' => $additionalStats,
        ]);
    }

    /**
     * Client Renewal Report V2 - Period Details Page
     * Shows detailed vehicle list and service records for a specific period
     */
    public function clientrenewalreportPeriod(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Get year and month from request
        $year = (int) ($request->query('year') ?? date('Y'));
        $month = (int) ($request->query('month') ?? date('n'));

        // Validate year and month
        if ($year < 2021 || $year > 2026) {
            $year = (int) date('Y');
        }
        if ($month < 1 || $month > 12) {
            $month = (int) date('n');
        }

        // Create period start date
        $periodStart = Carbon::create($year, $month, 1)->startOfMonth();
        $title = $periodStart->format('M y');

        // Get installation counts for CMC calculations
        $installCounts = Vehicle::query()
            ->where('client_id', $clientId)
            ->whereNull('deleted_at')
            ->whereNotNull('installation_date')
            ->selectRaw("DATE_FORMAT(installation_date, '%Y-%m') as ym")
            ->selectRaw("COUNT(*) as cnt")
            ->groupBy('ym')
            ->pluck('cnt', 'ym')
            ->toArray();

        // Calculate summary data
        $eligibleCount = $this->ksrtcCmcEligibleCountRolling($installCounts, $periodStart);
        $certificateCount = $this->ksrtcCmcEligibleWithCertificateCountRolling($clientId, $periodStart);
        $cmcCharge = $eligibleCount * 708;

        // Get service visits count for this month and year
        $servicedCount = (int) ServiceIn::query()
            ->from('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->where('v.client_id', $clientId)
            ->whereYear('si.date', $year)
            ->whereMonth('si.date', $month)
            ->count();

        // Get vehicles that need renewal (CMC eligible) for this period
        $cursor = $periodStart->copy()->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        $yms = [];
        while ($cursor->gte($min)) {
            if ($cursor->gt($threshold)) {
                $cursor->subMonths(6);
                continue;
            }
            $yms[] = $cursor->format('Y-m');
            $cursor->subMonths(6);
        }

        // Fetch vehicles needing renewal
        $renewalVehicles = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereIn(DB::raw("DATE_FORMAT(v.installation_date, '%Y-%m')"), $yms)
            ->where('v.installation_date', '<=', $threshold->toDateTimeString())
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        // Fetch service records for this month and year
        $serviceRecords = DB::table('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereYear('si.date', $year)
            ->whereMonth('si.date', $month)
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'si.date as service_date'
            )
            ->orderBy('si.date', 'desc')
            ->get();

        return view('Ksrtc::client-renewal-report-period', compact(
            'title',
            'year',
            'month',
            'cmcCharge',
            'eligibleCount',
            'certificateCount',
            'servicedCount',
            'renewalVehicles',
            'serviceRecords'
        ));
    }

    /**
     * Export renewal-needed vehicles for a period as CSV
     */
    public function clientrenewalreportPeriodExportRenewal(Request $request)
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }
        if (!$allowed) return abort(403);

        $clientId = 1778;
        $year = (int) ($request->query('year') ?? date('Y'));
        $month = (int) ($request->query('month') ?? date('n'));
        if ($year < 2021 || $year > 2026) $year = (int) date('Y');
        if ($month < 1 || $month > 12) $month = (int) date('n');

        $periodStart = Carbon::create($year, $month, 1)->startOfMonth();
        $min = Carbon::create(2021, 9, 1)->startOfMonth();
        $threshold = $periodStart->copy()->subYears(2)->endOfMonth();

        $yms = [];
        $cursor = $periodStart->copy();
        while ($cursor->gte($min)) {
            if ($cursor->gt($threshold)) {
                $cursor->subMonths(6);
                continue;
            }
            $yms[] = $cursor->format('Y-m');
            $cursor->subMonths(6);
        }

        $renewalVehicles = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereIn(DB::raw("DATE_FORMAT(v.installation_date, '%Y-%m')"), $yms)
            ->where('v.installation_date', '<=', $threshold->toDateTimeString())
            ->select('v.register_number as vehicle_no', 'g.imei', 'v.installation_date', DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status"))
            ->orderBy('v.register_number')
            ->get();

        $filename = 'ksrtc_renewal_list_' . $year . '_' . $month . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($renewalVehicles) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Vehicle No', 'IMEI', 'Installation Date', 'Certificate Attached']);
            foreach ($renewalVehicles as $r) {
                fputcsv($out, [
                    $r->vehicle_no,
                    $r->imei,
                    $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '',
                    $r->certificate_status
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export service records for a period as CSV
     */
    public function clientrenewalreportPeriodExportService(Request $request)
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }
        if (!$allowed) return abort(403);

        $clientId = 1778;
        $year = (int) ($request->query('year') ?? date('Y'));
        $month = (int) ($request->query('month') ?? date('n'));
        if ($year < 2021 || $year > 2026) $year = (int) date('Y');
        if ($month < 1 || $month > 12) $month = (int) date('n');

        $serviceRecords = DB::table('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereYear('si.date', $year)
            ->whereMonth('si.date', $month)
            ->select('v.register_number as vehicle_no', 'g.imei', 'si.date as service_date')
            ->orderBy('si.date', 'desc')
            ->get();

        $filename = 'ksrtc_service_records_' . $year . '_' . $month . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($serviceRecords) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Vehicle No', 'IMEI', 'Service Date']);
            foreach ($serviceRecords as $r) {
                fputcsv($out, [
                    $r->vehicle_no,
                    $r->imei,
                    $r->service_date ? Carbon::parse($r->service_date)->format('Y-m-d') : ''
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * All Vehicles List (Data Recharged)
     * Shows all vehicles for client 1778
     */
    public function allVehiclesList(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Fetch all vehicles for the client
        $vehicles = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        $title = 'All Vehicles (Data Recharged)';
        $count = $vehicles->count();

        return view('Ksrtc::vehicles-list', compact('title', 'count', 'vehicles'));
    }

    /**
     * Export all vehicles as CSV
     */
    public function allVehiclesExport(Request $request)
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) $allowed = true;
        elseif ($user->client && (int)$user->client->id === 1778) $allowed = true;
        if (!$allowed) return abort(403);

        $clientId = 1778;

        $rows = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        $filename = 'ksrtc_all_vehicles_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At', 'Certificate']);
            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date, $r->certificate_status]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Vehicles with Certificate Attached
     * Shows only vehicles that have warranty certificates
     */
    public function vehiclesWithCertificate(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Fetch vehicles with certificates
        $vehicles = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereNotNull('g.warrenty_certificate')
            ->where('g.warrenty_certificate', '!=', '')
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("'Yes' as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        $title = 'Vehicles with Certificate Attached';
        $count = $vehicles->count();

        return view('Ksrtc::vehicles-list', compact('title', 'count', 'vehicles'));
    }

    /**
     * Export vehicles with certificate as CSV
     */
    public function vehiclesWithCertificateExport(Request $request)
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) $allowed = true;
        elseif ($user->client && (int)$user->client->id === 1778) $allowed = true;
        if (!$allowed) return abort(403);

        $clientId = 1778;

        $rows = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereNotNull('g.warrenty_certificate')
            ->where('g.warrenty_certificate', '!=', '')
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date'
            )
            ->orderBy('v.register_number')
            ->get();

        $filename = 'ksrtc_vehicles_with_certificate_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);
            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show all vehicles replaced by uni140
     */
    public function replacedByUni140List()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Fetch vehicles where replaced_by_uni140 = 1
        $vehicles = DB::table('abc_temp_ksrtc_add_data as add_data')
            ->join('gps_summery as g', 'add_data.imei', '=', 'g.imei')
            ->join('vehicles as v', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->where('add_data.replaced_by_uni140', 1)
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date'
            )
            ->orderBy('v.register_number')
            ->get();

        $title = 'Vehicles Replaced by uni140';
        $count = $vehicles->count();

        return view('Ksrtc::replaced-vehicles-list', compact('title', 'count', 'vehicles'));
    }

    /**
     * Export replaced-by-uni140 vehicles as CSV
     */
    public function replacedByUni140Export(Request $request)
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) $allowed = true;
        elseif ($user->client && (int)$user->client->id === 1778) $allowed = true;
        if (!$allowed) return abort(403);

        $clientId = 1778;

        $rows = DB::table('abc_temp_ksrtc_add_data as add_data')
            ->join('gps_summery as g', 'add_data.imei', '=', 'g.imei')
            ->join('vehicles as v', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->where('add_data.replaced_by_uni140', 1)
            ->select('v.register_number as vehicle_no', 'g.imei', 'v.installation_date')
            ->orderBy('v.register_number')
            ->get();

        $filename = 'ksrtc_replaced_by_uni140_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At']);
            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show all service records for the client
     */
    public function serviceReportList()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Fetch all service records
        $services = DB::table('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'si.date as service_date'
            )
            ->orderBy('si.date', 'desc')
            ->get();

        $title = 'Service Report';
        $count = $services->count();

        return view('Ksrtc::service-report-list', compact('title', 'count', 'services'));
    }

    /**
     * Export service report as CSV
     */
    public function serviceReportExport()
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) $allowed = true;
        elseif ($user->client && (int)$user->client->id === 1778) $allowed = true;
        if (!$allowed) return abort(403);

        $clientId = 1778;
        $services = DB::table('cd_service_ins as si')
            ->join('vehicles as v', 'v.register_number', '=', 'si.vehicle_no')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->select('v.register_number as vehicle_no', 'g.imei', 'si.date as service_date')
            ->orderBy('si.date', 'desc')
            ->get();

        $filename = 'ksrtc_service_report_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($services) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Vehicle No', 'IMEI', 'Service Date']);
            foreach ($services as $s) {
                fputcsv($out, [
                    $s->vehicle_no,
                    $s->imei,
                    $s->service_date ? Carbon::parse($s->service_date)->format('Y-m-d') : ''
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show all vehicles that are not paid (not in abc_ksrtc_amount_given table with paid_status = 1)
     */
    public function notPaidList(){
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        // Only allow root or client 1778
        $allowed = false;
        if ($user->root) {
            $allowed = true;
        } elseif ($user->client && (int)$user->client->id === 1778) {
            $allowed = true;
        }

        if (!$allowed) {
            abort(403, 'Access denied');
        }

        $clientId = 1778;

        // Fetch vehicles NOT present in abc_ksrtc_amount_given table with paid_status = 1
        $vehicles = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereNotIn('v.id', function ($query) {
                $query->select('vehicles_id')
                    ->from('abc_ksrtc_amount_given')
                    ->where('paid_status', 1);
            })
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        $title = 'Not Paid Vehicles';
        $count = $vehicles->count();

        return view('Ksrtc::vehicles-list', compact('title', 'count', 'vehicles'));
    }

    /**
     * Export not paid vehicles as CSV
     */
    public function notPaidExport()
    {
        $user = Auth::user();
        if (!$user) return abort(403);
        $allowed = false;
        if ($user->root) $allowed = true;
        elseif ($user->client && (int)$user->client->id === 1778) $allowed = true;
        if (!$allowed) return abort(403);

        $clientId = 1778;

        $rows = DB::table('vehicles as v')
            ->join('gps_summery as g', 'v.gps_id', '=', 'g.id')
            ->where('v.client_id', $clientId)
            ->whereNull('v.deleted_at')
            ->whereNotNull('v.installation_date')
            ->whereNotIn('v.id', function ($query) {
                $query->select('vehicles_id')
                    ->from('abc_ksrtc_amount_given')
                    ->where('paid_status', 1);
            })
            ->select(
                'v.register_number as vehicle_no',
                'g.imei',
                'v.installation_date',
                DB::raw("IF(g.warrenty_certificate IS NOT NULL AND g.warrenty_certificate != '', 'Yes', 'No') as certificate_status")
            )
            ->orderBy('v.register_number')
            ->get();

        $filename = 'ksrtc_not_paid_vehicles_' . date('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['SL No', 'Vehicle No', 'IMEI', 'Installed At', 'Certificate']);
            $i = 1;
            foreach ($rows as $r) {
                $date = $r->installation_date ? Carbon::parse($r->installation_date)->format('Y-m-d') : '';
                fputcsv($out, [$i++, $r->vehicle_no, $r->imei, $date, $r->certificate_status]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
