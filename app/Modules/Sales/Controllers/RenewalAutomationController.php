<?php

namespace App\Modules\Sales\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Modules\Gps\Models\Gps;
use App\Modules\Sales\Models\Callcenter;
use App\Modules\Sales\Models\GpsAutoAssignment;
use App\Modules\Sales\Models\RenewalNotification;
use App\Modules\Sales\Models\GpsAssignmentLog;
use App\Modules\Sales\Models\SalesAssignGps;
use App\Modules\Sales\Models\GpsFollowup;
use App\Modules\Gps\Models\GpsOrder;

class RenewalAutomationController extends Controller{
    /**
     * Execute Auto-Assignment Process
     * Triggered manually via dashboard button
     */
    public function executeAutoAssignment(Request $request){
        $startTime = microtime(true);
        $results = [
            'success' => false,
            'test_mode' => config('renewal_automation.test_mode', false),
            'processed' => 0,
            'assigned' => 0,
            'skipped' => 0,
            'errors' => [],
            'details' => [],
        ];

        // Run follow-up escalation check before assigning
        try {
            // Call checkFollowupEscalation (simulate a request object)
            $this->checkFollowupEscalation();
            // Get expiring GPS devices
            $expiringDevices = $this->getExpiringDevices();
            
            Log::info("[AUTO-ASSIGN] Retrieved devices count: " . $expiringDevices->count());
            Log::info("[AUTO-ASSIGN] Device IDs: " . $expiringDevices->pluck('id')->implode(', '));
            
            if ($expiringDevices->isEmpty()) {
                $results['success'] = true;
                $results['message'] = 'No expiring GPS devices found that need assignment.';
                Log::info("[AUTO-ASSIGN] No devices found to process");
                return response()->json($results);
            }
            
            // Process each device
            foreach ($expiringDevices as $gps) {
                $results['processed']++;
                Log::info("[AUTO-ASSIGN] Processing GPS {$gps->id} (IMEI: {$gps->imei})");
                
                try {
                    $assignmentResult = $this->assignGpsToCallcenter($gps);
                    Log::info("[AUTO-ASSIGN] GPS {$gps->id} result: " . ($assignmentResult['assigned'] ? 'ASSIGNED' : 'SKIPPED') . " - Reason: " . ($assignmentResult['reason'] ?? 'Success'));
                    
                    if ($assignmentResult['assigned']) {
                        $results['assigned']++;
                        $results['details'][] = [
                            'gps_id' => $gps->id,
                            'imei' => $gps->imei,
                            'callcenter' => $assignmentResult['callcenter_name'],
                            'action' => $assignmentResult['action'],
                        ];
                    } else {
                        $results['skipped']++;
                        $results['details'][] = [
                            'gps_id' => $gps->id,
                            'imei' => $gps->imei,
                            'reason' => $assignmentResult['reason'],
                        ];
                    }
                    
                } catch (\Exception $e) {
                    $results['errors'][] = "GPS ID {$gps->id}: " . $e->getMessage();
                    Log::error("Auto-assignment error for GPS {$gps->id}: " . $e->getMessage());
                }
            }
            
            $executionTime = round(microtime(true) - $startTime, 2);
            $results['success'] = true;
            $results['execution_time'] = $executionTime . 's';
            $results['message'] = "Processed {$results['processed']} devices. Assigned: {$results['assigned']}, Skipped: {$results['skipped']}";
            
            Log::info("Auto-assignment completed", $results);
            
        } catch (\Exception $e) {
            $results['success'] = false;
            $results['message'] = 'Error during auto-assignment: ' . $e->getMessage();
            Log::error("Auto-assignment failed: " . $e->getMessage());
        }
        
        return response()->json($results);
    }
    
    /**
     * Get GPS devices expiring within configured window
     */
    protected function getExpiringDevices(){
        $testMode = config('renewal_automation.test_mode', false);
        $expiryWindowDays = config('renewal_automation.expiry_window_days', 30);

        $query = Gps::query()
            ->whereNotNull('validity_date')
            ->where('validity_date', '<=', now()->addDays($expiryWindowDays))
            ->whereRaw('(pay_status IS NULL OR pay_status != 1)');
        
        // Test mode: filter by specific GPS IDs
        if ($testMode) {
            Log::info("[AUTO-ASSIGN] Test mode ACTIVE");
            $testGpsIds = config('renewal_automation.test_gps_ids', '');
            if (!empty($testGpsIds)) {
                $idsArray = array_map('trim', explode(',', $testGpsIds));
                Log::info("[AUTO-ASSIGN] Test GPS IDs configured: " . implode(', ', $idsArray));
                $query->whereIn('id', $idsArray);
            }
            $maxPerRun = config('renewal_automation.test_max_per_run', 150);
            Log::info("[AUTO-ASSIGN] Test max per run: {$maxPerRun}");
            $query->limit($maxPerRun);
        }
        
        return $query->get();
    }
    
    /**
     * Assign GPS device to call center
     */
    protected function assignGpsToCallcenter($gps){
        $result = [
            'assigned' => false,
            'reason' => '',
            'callcenter_name' => '',
            'action' => '',
        ];
        
        // Check if already assigned (in either table)
        $existingAutoAssignment = GpsAutoAssignment::where('gps_id', $gps->id)
            ->whereIn('status', ['active', 'escalated'])
            ->first();
            
        $existingManualAssignment = SalesAssignGps::where('gps_id', $gps->id)
            ->whereNull('deleted_at')
            ->first();
        
        if ($existingAutoAssignment) {
            Log::info("[AUTO-ASSIGN] GPS {$gps->id} already auto-assigned (status: {$existingAutoAssignment->status})");
            $result['reason'] = 'Already auto-assigned (active)';
            return $result;
        }
        
        if ($existingManualAssignment && config('renewal_automation.skip_if_manually_assigned', true)) {
            Log::info("[AUTO-ASSIGN] GPS {$gps->id} already manually assigned");
            $result['reason'] = 'Already manually assigned';
            return $result;
        }
        
        // Find best call center
        $callcenterId = $this->findBestCallcenter($gps);
        if (!$callcenterId) {
            $result['reason'] = 'No suitable call center found';
            return $result;
        }

        // Count active auto-assignments for this call center where GPS is not yet paid
        $autoAssignments = GpsAutoAssignment::where('callcenter_id', $callcenterId)
            ->whereIn('status', ['active', 'escalated'])
            ->whereHas('gps', function($query) {
                $query->where(function($q) {
                    $q->whereNull('pay_status')
                      ->orWhere('pay_status', '!=', 1);
                });
            })
            ->pluck('gps_id')
            ->toArray();
        // Deduplicate GPS IDs to avoid double-counting if duplicate rows exist
        $autoAssignments = array_values(array_unique($autoAssignments));
        $autoCount = count($autoAssignments);

        // Count active manual assignments where GPS is not yet paid, excluding those already in auto-assignments
        $manualCount = SalesAssignGps::where('callcenter_id', $callcenterId)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->whereNotIn('gps_id', $autoAssignments)
            ->whereHas('gps', function($query) {
                $query->where(function($q) {
                    $q->whereNull('pay_status')
                      ->orWhere('pay_status', '!=', 1);
                });
            })
            ->count();

        $totalActive = $autoCount + $manualCount;
        
        // Compare with dashboard count for debugging
        $dashboardCount = SalesAssignGps::where('callcenter_id', $callcenterId)->count();
        $dashboardUnpaidCount = SalesAssignGps::where('callcenter_id', $callcenterId)->where('status', 0)->whereNull('deleted_at')->count();

        // Use configurable per-callcenter max limit (default 200)
        $maxPerCallcenter = config('renewal_automation.max_assignments_per_callcenter', 200);

        // Debug logging
        Log::info("[AUTO-ASSIGN] GPS {$gps->id} callcenter {$callcenterId} count breakdown: auto={$autoCount}, manual_unpaid={$manualCount}, total_active={$totalActive}, dashboard_all={$dashboardCount}, dashboard_unpaid_only={$dashboardUnpaidCount}, max_allowed={$maxPerCallcenter}");

        if ($totalActive >= $maxPerCallcenter) {
            Log::info("[AUTO-ASSIGN] GPS {$gps->id} call center has {$maxPerCallcenter} or more active assignments");
            $result['reason'] = "Call center has {$maxPerCallcenter} or more active assignments";
            return $result;
        }

        $callcenter = Callcenter::find($callcenterId);

        DB::beginTransaction();
        try {
            $assignmentDate = now();
            $followupDays = config('renewal_automation.followup_wait_days', 3);

            // Create auto assignment record
            $autoAssignment = GpsAutoAssignment::create([
                'gps_id' => $gps->id,
                'callcenter_id' => $callcenterId,
                'assigned_by_system' => true,
                'assignment_date' => $assignmentDate,
                'expected_followup_by' => $assignmentDate->copy()->addDays($followupDays),
                'status' => 'active',
                'reassignment_count' => 0,
            ]);

            // Also create record in sales_imei_assign table (standard assignment table)
            SalesAssignGps::create([
                'gps_id' => $gps->id,
                'callcenter_id' => $callcenterId,
                'assigned_by' => Auth::id() ?? 1, // Use logged-in user or system user ID 1
                'status' => 0, // Not renewed yet
            ]);

            // Log the assignment
            GpsAssignmentLog::logInitialAssignment(
                $autoAssignment->id,
                $gps->id,
                $callcenterId
            );

            // Create notification (if enabled) - Commented out for now
            // if (config('renewal_automation.notify_sales_on_reassignment', true)) {
            //     $salesUsers = $this->getSalesUsers();
            //     foreach ($salesUsers as $user) {
            //         RenewalNotification::createAutoAssigned(
            //             $user->id,
            //             $gps->id,
            //             $autoAssignment->id,
            //             $callcenter->name
            //         );
            //     }
            // }

            DB::commit();

            $result['assigned'] = true;
            $result['callcenter_name'] = $callcenter->name;
            $result['action'] = 'initial_assign';

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $result;
    }
    
    /**
     * Find best call center for assignment
     */
    protected function findBestCallcenter($gps){
        // Try to find who did the last renewal
        if (config('renewal_automation.prefer_last_renewer', true)) {
            Log::info("[AUTO-ASSIGN] GPS {$gps->id} checking for last renewer");
            $lastOrder = GpsOrder::where('gps_id', $gps->id)
                ->whereNotNull('sales_by')
                ->orderBy('created_at', 'desc')
                ->first();
            
            if ($lastOrder && $lastOrder->sales_by) {
                Log::info("[AUTO-ASSIGN] GPS {$gps->id} found last order: sales_by={$lastOrder->sales_by}, order_date={$lastOrder->created_at}");
                // Find call center by user_id (sales_by stores user ID, not code)
                $callcenter = Callcenter::where('user_id', $lastOrder->sales_by)
                    ->whereNull('deleted_at')
                    ->first();
                if ($callcenter) {
                    $pendingCount = $this->getPendingCountForCallcenter($callcenter->id);
                    Log::info("[AUTO-ASSIGN] GPS {$gps->id} last renewer call center found: cc_id={$callcenter->id}, cc_name={$callcenter->name}, pending_count={$pendingCount}");
                    Log::info("[AUTO-ASSIGN] GPS {$gps->id} SELECTION METHOD: Last Renewer (cc_id={$callcenter->id})");
                    return $callcenter->id;
                } else {
                    Log::info("[AUTO-ASSIGN] GPS {$gps->id} no call center found for user_id={$lastOrder->sales_by}");
                }
            } else {
                Log::info("[AUTO-ASSIGN] GPS {$gps->id} no last order found or sales_by is null");
            }
        }
        
        // Fallback: assign to call center with lowest pending count
        if (config('renewal_automation.fallback_to_lowest_count', true)) {
            Log::info("[AUTO-ASSIGN] GPS {$gps->id} using fallback: lowest count method");
            $selectedId = $this->getCallcenterWithLowestPending();
            if ($selectedId) {
                $callcenter = Callcenter::find($selectedId);
                $pendingCount = $this->getPendingCountForCallcenter($selectedId);
                Log::info("[AUTO-ASSIGN] GPS {$gps->id} SELECTION METHOD: Lowest Count (cc_id={$selectedId}, cc_name={$callcenter->name}, pending_count={$pendingCount})");
            }
            return $selectedId;
        }
        
        Log::info("[AUTO-ASSIGN] GPS {$gps->id} no call center selection method enabled");
        return null;
    }
    
    /**
     * Get call center with lowest pending count
     */
    protected function getCallcenterWithLowestPending(){
        $callcenters = Callcenter::all();
        $minCount = PHP_INT_MAX;
        $selectedCallcenterId = null;
        
        Log::info("[AUTO-ASSIGN] Evaluating all call centers for lowest count:");
        foreach ($callcenters as $callcenter) {
            $pendingCount = $this->getPendingCountForCallcenter($callcenter->id);
            Log::info("[AUTO-ASSIGN]   - cc_id={$callcenter->id}, cc_name={$callcenter->name}, pending_count={$pendingCount}");
            
            if ($pendingCount < $minCount) {
                $minCount = $pendingCount;
                $selectedCallcenterId = $callcenter->id;
            }
        }
        
        Log::info("[AUTO-ASSIGN] Selected call center with lowest count: cc_id={$selectedCallcenterId}, min_count={$minCount}");
        return $selectedCallcenterId;
    }
    
    /**
     * Calculate pending count for call center
     */
    protected function getPendingCountForCallcenter($callcenterId){
        // Get all active auto-assigned GPS IDs for this call center where GPS is not yet paid
        $autoGpsIds = GpsAutoAssignment::where('callcenter_id', $callcenterId)
            ->whereIn('status', ['active', 'escalated'])
            ->whereHas('gps', function($query) {
                $query->where(function($q) {
                    $q->whereNull('pay_status')
                      ->orWhere('pay_status', '!=', 1);
                });
            })
            ->pluck('gps_id')
            ->toArray();

        // Get all active manual assignments for this call center where GPS is not yet paid, excluding those already in auto-assignments
        $manualGpsIds = SalesAssignGps::where('callcenter_id', $callcenterId)
            ->where('status', 0)
            ->whereNull('deleted_at')
            ->whereNotIn('gps_id', $autoGpsIds)
            ->whereHas('gps', function($query) {
                $query->where(function($q) {
                    $q->whereNull('pay_status')
                      ->orWhere('pay_status', '!=', 1);
                });
            })
            ->pluck('gps_id')
            ->toArray();

        // Merge and count unique GPS IDs
        $allGpsIds = array_unique(array_merge($autoGpsIds, $manualGpsIds));
        return count($allGpsIds);
    }
    
    /**
     * Check Follow-up and Escalate
     * Triggered manually via dashboard button
     */
    public function checkFollowupEscalation(){
        $results = [
            'success' => false,
            'checked' => 0,
            'reassigned' => 0,
            'escalated' => 0,
            'details' => [],
        ];
        
        try {
            // Get overdue assignments using new logic
            $overdueAssignments = $this->getOverdueAssignments();

            if (empty($overdueAssignments)) {
                $results['success'] = true;
                $results['message'] = 'No overdue follow-ups found.';
                return response()->json($results);
            }

            foreach ($overdueAssignments as $assignment) {
                $results['checked']++;

                // No follow-up - reassign or escalate
                if ($assignment->canReassign()) {
                    $this->reassignGps($assignment);
                    $results['reassigned']++;
                    $results['details'][] = [
                        'gps_id' => $assignment->gps_id,
                        'action' => 'reassigned',
                        'attempt' => $assignment->reassignment_count + 1,
                    ];
                } elseif ($assignment->shouldEscalate()) {
                    $this->escalateGps($assignment);
                    $results['escalated']++;
                    $results['details'][] = [
                        'gps_id' => $assignment->gps_id,
                        'action' => 'escalated',
                    ];
                }
            }

            $results['success'] = true;
            $results['message'] = "Checked {$results['checked']} assignments. Reassigned: {$results['reassigned']}, Escalated: {$results['escalated']}";

        } catch (\Exception $e) {
            $results['success'] = false;
            $results['message'] = 'Error checking follow-ups: ' . $e->getMessage();
            Log::error("Follow-up check failed: " . $e->getMessage());
        }

        return response()->json($results);
    }

    /**
     * Get overdue assignments for follow-up (custom logic)
     * - If no followup exists for assignment, it's overdue
     * - If followup exists, check if followup_wait_days have passed since expected_followup_by
     */
    protected function getOverdueAssignments(){
        $overdue = [];
        $waitDays = config('renewal_automation.followup_wait_days', 7);
        $now = now();

        // Get all active auto-assignments
        $assignments = GpsAutoAssignment::where('status', 'active')->get();

        foreach ($assignments as $assignment) {
            // Get latest followup for this GPS after assignment date
            $latestFollowup = GpsFollowup::where('gps_id', $assignment->gps_id)
                ->where('created_at', '>=', $assignment->assignment_date)
                ->orderBy('created_at', 'desc')
                ->first();

            if (!$latestFollowup) {
                // No followup at all, check if waitDays have passed since assignment_date
                $assignmentDate = $assignment->assignment_date;
                if ($assignmentDate && $now->diffInDays($assignmentDate, false) < -$waitDays) {
                    $overdue[] = $assignment;
                }
                continue;
            }

            // If followup exists, check if waitDays have passed since expected_followup_by
            $expectedDate = $assignment->expected_followup_by;
            // $now->diffInDays($expectedDate, false) will be negative if $now is after $expectedDate
            if ($expectedDate && $now->diffInDays($expectedDate, false) < -$waitDays) {
                $overdue[] = $assignment;
            }
        }

        return $overdue;
    }
    
    /**
     * Reassign GPS to another call center
     */
    protected function reassignGps($assignment){
        DB::beginTransaction();
        try {
            $oldCallcenterId = $assignment->callcenter_id;
            $newCallcenterId = $this->getCallcenterWithLowestPending();
            
            // Skip if same call center
            if ($oldCallcenterId == $newCallcenterId) {
                $newCallcenterId = $this->getNextCallcenter($oldCallcenterId);
            }
            
            $assignment->callcenter_id = $newCallcenterId;
            $assignment->reassignment_count++;
            $assignment->assignment_date = now();
            $assignment->expected_followup_by = now()->addDays(config('renewal_automation.followup_wait_days', 7));
            $assignment->followup_completed = false;
            $assignment->followup_completed_at = null;
            $assignment->save();
            
            // Update sales_imei_assign table
            SalesAssignGps::where('gps_id', $assignment->gps_id)
                ->where('callcenter_id', $oldCallcenterId)
                ->whereNull('deleted_at')
                ->update(['callcenter_id' => $newCallcenterId]);
            
            // Log reassignment
            GpsAssignmentLog::logReassignment(
                $assignment->id,
                $assignment->gps_id,
                $oldCallcenterId,
                $newCallcenterId,
                $assignment->reassignment_count
            );
            
            // Notify sales - Commented out for now
            // if (config('renewal_automation.notify_sales_on_reassignment', true)) {
            //     $oldCallcenter = Callcenter::find($oldCallcenterId);
            //     $newCallcenter = Callcenter::find($newCallcenterId);
            //     
            //     $salesUsers = $this->getSalesUsers();
            //     foreach ($salesUsers as $user) {
            //         RenewalNotification::createReassignment(
            //             $user->id,
            //             $assignment->gps_id,
            //             $assignment->id,
            //             $oldCallcenter->name,
            //             $newCallcenter->name,
            //             $assignment->reassignment_count
            //         );
            //     }
            // }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Escalate GPS to sales dashboard
     */
    protected function escalateGps($assignment){
        DB::beginTransaction();
        try {
            $assignment->escalate();
            
            // Log escalation
            GpsAssignmentLog::logEscalation(
                $assignment->id,
                $assignment->gps_id,
                $assignment->callcenter_id
            );
            
            // Notify sales (urgent) - Commented out for now
            // if (config('renewal_automation.notify_sales_on_escalation', true)) {
            //     $gps = $assignment->gps;
            //     $salesUsers = $this->getSalesUsers();
            //     
            //     foreach ($salesUsers as $user) {
            //         RenewalNotification::createEscalation(
            //             $user->id,
            //             $assignment->gps_id,
            //             $assignment->id,
            //             $gps->imei ?? 'N/A'
            //         );
            //     }
            // }
            
            DB::commit();
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    /**
     * Get next call center (round-robin)
     */
    protected function getNextCallcenter($currentCallcenterId){
        $callcenters = Callcenter::orderBy('id')->pluck('id')->toArray();
        $currentIndex = array_search($currentCallcenterId, $callcenters);
        
        $nextIndex = ($currentIndex + 1) % count($callcenters);
        return $callcenters[$nextIndex];
    }
    
    /**
     * Get urgent list for sales dashboard
     */
    public function getUrgentList(Request $request){
        $perPage = $request->get('per_page', 25);
        
        $urgentDevices = GpsAutoAssignment::with(['gps', 'callcenter'])
            ->escalated()
            ->orderBy('escalation_date', 'desc')
            ->paginate($perPage);
        
        return response()->json([
            'success' => true,
            'data' => $urgentDevices,
        ]);
    }
    
    /**
     * Show auto-assigned renewals page
     */
    public function showAssignmentsPage(){
        $callcenters = Callcenter::whereNull('deleted_at')->get();
        
        // Check if user is Call_Center role
        $isCallCenter = \Auth::user()->hasRole('Call_Center');
        $userCallcenterId = null;
        
        if ($isCallCenter) {
            $userCallcenterId = \Auth::user()->callcenter->id ?? null;
        }
        
        return view('Sales::auto-assigned-renewals', compact('callcenters', 'isCallCenter', 'userCallcenterId'));
    }
    
    /**
     * Get assignments list with filters (AJAX)
     * Combines automated assignments (abc_gps_auto_assignments) and regular assignments (sales_imei_assign)
     */
    public function getAssignmentsList(Request $request){
        $perPage = 25;
        $statusFilter = $request->status;

        // If a global search is provided, ignore the status filter so search runs across all statuses
        $incomingSearch = trim($request->get('search', ''));
        if ($incomingSearch !== '') {
            $statusFilter = null;
        }
        
        // Check if user is Call_Center role and auto-filter by their callcenter_id
        $isCallCenter = \Auth::user()->hasRole('Call_Center');
        $filterCallcenterId = $request->callcenter_id;
        
        if ($isCallCenter) {
            $filterCallcenterId = \Auth::user()->callcenter->id ?? null;
        }
        
        // Get automated assignments
        $autoQuery = GpsAutoAssignment::with(['gps', 'callcenter'])
            ->select('abc_gps_auto_assignments.*')
            ->join('gps_summery', 'abc_gps_auto_assignments.gps_id', '=', 'gps_summery.id');
        
        // Apply status filter for auto assignments
        if ($statusFilter === 'assigned') {
            $autoQuery->where('abc_gps_auto_assignments.status', 'active')
                      ->where('gps_summery.pay_status', '!=', 1);
        } elseif ($statusFilter === 'completed') {
            $autoQuery->where('abc_gps_auto_assignments.status', 'completed')
                      ->where('gps_summery.pay_status', 1);
        } elseif ($statusFilter === 'escalated') {
            $autoQuery->where('abc_gps_auto_assignments.status', 'escalated')
                      ->where('gps_summery.pay_status', '!=', 1);
        } elseif ($statusFilter === 'pending') {
            // For pending, get all active assignments, will filter later
            $autoQuery->where('abc_gps_auto_assignments.status', 'active')
                      ->where('gps_summery.pay_status', '!=', 1);
        }
        
        if ($filterCallcenterId) {
            $autoQuery->where('abc_gps_auto_assignments.callcenter_id', $filterCallcenterId);
        }
        
        $autoAssignments = $autoQuery->get();
        
        // Get regular assignments (not in automation system)
        $regularQuery = SalesAssignGps::with(['gps', 'callcenter'])
            ->select('sales_imei_assign.*')
            ->join('gps_summery', 'sales_imei_assign.gps_id', '=', 'gps_summery.id')
            ->whereNull('sales_imei_assign.deleted_at')
            ->whereNotIn('sales_imei_assign.gps_id', function($query) {
                $query->select('gps_id')
                    ->from('abc_gps_auto_assignments')
                    ->whereIn('status', ['active', 'escalated', 'completed']);
            });
        
        // Apply status filter for regular assignments
        if ($statusFilter === 'assigned') {
            $regularQuery->where('gps_summery.pay_status', '!=', 1);
        } elseif ($statusFilter === 'completed') {
            $regularQuery->where('gps_summery.pay_status', 1);
        } elseif ($statusFilter === 'escalated') {
            // Regular assignments can't be escalated, skip them
            $regularQuery->whereRaw('1 = 0');
        } elseif ($statusFilter === 'pending') {
            // For pending, get all, will filter later
            $regularQuery->where('gps_summery.pay_status', '!=', 1);
        }

        if ($filterCallcenterId) {
            $regularQuery->where('sales_imei_assign.callcenter_id', $filterCallcenterId);
        }
        
        $regularAssignments = $regularQuery->get();
        
        // Combine and format all assignments
        $combinedData = collect();
        
        // Format automated assignments
        foreach ($autoAssignments as $item) {
            $hasFollowup = GpsFollowup::where('gps_id', $item->gps_id)->exists();
            $payStatus = $item->gps->pay_status ?? 0;
            
            // Get latest followup data if exists
            $latestFollowup = null;
            $nextFollowDate = null;
            $followupDescription = null;
            if ($hasFollowup) {
                $latestFollowup = GpsFollowup::where('gps_id', $item->gps_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($latestFollowup) {
                    // Check if next_follow_date is valid (not 0000-00-00)
                    if ($latestFollowup->next_follow_date && $latestFollowup->next_follow_date !== '0000-00-00') {
                        $nextFollowDate = $latestFollowup->next_follow_date;
                    }
                    $followupDescription = $latestFollowup->description;
                }
            }
            
            // Determine followup_status
            $followupStatus = null;
            $completedDate = null;
            if ($item->status === 'completed') {
                $followupStatus = 'completed';
                $completedDate = $item->completed_at;
            } elseif ($item->status === 'escalated') {
                $followupStatus = 'escalated';
            } elseif ($item->status === 'active') {
                if ($hasFollowup && $payStatus == 0) {
                    $followupStatus = 'pending';
                } else {
                    $followupStatus = 'assigned';
                }
            }
            
            $daysRemaining = null;
            if ($item->gps && $item->gps->validity_date) {
                $validityDate = \Carbon\Carbon::parse($item->gps->validity_date);
                $now = now();
                // Positive if future, negative if past
                $daysRemaining = $now->diffInDays($validityDate, false);
            }
            
            $formatted = [
                'id' => $item->id,
                'gps_id' => $item->gps_id,
                'gps_imei' => $item->gps->imei ?? null,
                'vehicle_no' => $item->gps->vehicle_no ?? null,
                'validity_date' => $item->gps->validity_date ?? null,
                'warrenty_certificate' => $item->gps->warrenty_certificate ?? null,
                'callcenter_id' => $item->callcenter_id,
                'callcenter_name' => $item->callcenter->name ?? 'N/A',
                'assignment_date' => $item->assignment_date ? $item->assignment_date->format('Y-m-d H:i:s') : null,
                'followup_status' => $followupStatus,
                'reassignment_count' => $item->reassignment_count,
                'status' => $item->status,
                'days_remaining' => $daysRemaining,
                'completed_date' => $completedDate ? $completedDate->format('Y-m-d H:i:s') : null,
                'next_follow_date' => $nextFollowDate,
                'followup_description' => $followupDescription,
                'source_type' => 'auto',
                'created_at' => $item->created_at,
            ];
            
            $combinedData->push($formatted);
        }
        
        // Format regular assignments
        foreach ($regularAssignments as $item) {
            $hasFollowup = GpsFollowup::where('gps_id', $item->gps_id)->exists();
            $payStatus = $item->gps->pay_status ?? 0;
            
            // Get latest followup data if exists
            $latestFollowup = null;
            $nextFollowDate = null;
            $followupDescription = null;
            if ($hasFollowup) {
                $latestFollowup = GpsFollowup::where('gps_id', $item->gps_id)
                    ->orderBy('created_at', 'desc')
                    ->first();
                if ($latestFollowup) {
                    // Check if next_follow_date is valid (not 0000-00-00)
                    if ($latestFollowup->next_follow_date && $latestFollowup->next_follow_date !== '0000-00-00') {
                        $nextFollowDate = $latestFollowup->next_follow_date;
                    }
                    $followupDescription = $latestFollowup->description;
                }
            }
            
            // Determine followup_status
            $followupStatus = null;
            $completedDate = null;
            if ($payStatus == 1) {
                $followupStatus = 'completed';
                // Get payment date from gps_summery only
                $completedDate = $item->gps->pay_date;
            } elseif ($hasFollowup && $payStatus == 0) {
                $followupStatus = 'pending';
            } else {
                $followupStatus = 'assigned';
            }
            
            $daysRemaining = null;
            if ($item->gps && $item->gps->validity_date) {
                $validityDate = \Carbon\Carbon::parse($item->gps->validity_date);
                $now = now();
                // Positive if future, negative if past
                $daysRemaining = $now->diffInDays($validityDate, false);
            }
            
            $formatted = [
                'id' => 'regular_' . $item->id,
                'gps_id' => $item->gps_id,
                'gps_imei' => $item->gps->imei ?? null,
                'vehicle_no' => $item->gps->vehicle_no ?? null,
                'validity_date' => $item->gps->validity_date ?? null,
                'warrenty_certificate' => $item->gps->warrenty_certificate ?? null,
                'callcenter_id' => $item->callcenter_id,
                'callcenter_name' => $item->callcenter->name ?? 'N/A',
                'assignment_date' => $item->created_at ? $item->created_at->format('Y-m-d H:i:s') : null,
                'followup_status' => $followupStatus,
                'reassignment_count' => 0,
                'status' => 'active',
                'days_remaining' => $daysRemaining,
                'completed_date' => $completedDate,
                'next_follow_date' => $nextFollowDate,
                'followup_description' => $followupDescription,
                'source_type' => 'regular',
                'created_at' => $item->created_at,
            ];
            
            $combinedData->push($formatted);
        }
        
        // Apply pending filter if selected
        // Apply global search filter if provided (search IMEI, GPS id, vehicle no, callcenter name, followup note)
        $search = trim($request->get('search', ''));
        if ($search !== '') {
            $s = strtolower($search);
            $combinedData = $combinedData->filter(function($item) use ($s) {
                $fields = ['gps_id', 'gps_imei', 'vehicle_no', 'callcenter_name', 'followup_description'];
                foreach ($fields as $f) {
                    if (!empty($item[$f]) && strpos(strtolower((string)$item[$f]), $s) !== false) {
                        return true;
                    }
                }
                return false;
            })->values();
        }

        if ($statusFilter === 'pending') {
            $combinedData = $combinedData->filter(function($item) {
                return $item['followup_status'] === 'pending';
            });
        }
        
        // Sort by appropriate field based on filter
        if ($statusFilter === 'completed') {
            // For completed, sort by completed_date (pay_date) desc - most recent first
            $combinedData = $combinedData->sortByDesc('completed_date')->values();
        } elseif ($statusFilter === 'pending' && $isCallCenter) {
            // For pending (follow-up), sort by next_follow_date asc - most urgent first (call center only)
            // Null dates should come last, so we use a custom sort
            $combinedData = $combinedData->sortBy(function($item) {
                // If next_follow_date is null, return a far future date to push it to the end
                return $item['next_follow_date'] ?? '9999-12-31';
            })->values();
        } else {
            // For others, sort by created_at desc (assignment date)
            $combinedData = $combinedData->sortByDesc('created_at')->values();
        }
        
        // Manual pagination
        $total = $combinedData->count();
        $currentPage = $request->page ?? 1;
        $offset = ($currentPage - 1) * $perPage;
        $paginatedData = $combinedData->slice($offset, $perPage)->values();
        
        return response()->json([
            'success' => true,
            'data' => $paginatedData,
            'pagination' => [
                'current_page' => (int) $currentPage,
                'last_page' => (int) ceil($total / $perPage),
                'total' => $total,
            ],
        ]);
    }
    
    /**
     * Get statistics for dashboard widget
     * Combines automated assignments and regular sales assignments
     */
    public function getStats(Request $request){
        // Check if filtering for specific call center
        $callcenterId = $request->get('callcenter_id');
        try {

        // Automated system stats
        $autoAssignedActive = GpsAutoAssignment::active()
            ->when($callcenterId, function($query) use ($callcenterId) {
                $query->where('callcenter_id', $callcenterId);
            })
            ->whereHas('gps', function($query) {
                $query->where('pay_status', '!=', 1);
            })
            ->count();
        $autoAssignedUrgent = GpsAutoAssignment::escalated()
            ->when($callcenterId, function($query) use ($callcenterId) {
                $query->where('callcenter_id', $callcenterId);
            })
            ->count();
        
        // Pending follow-up: GPS that have been followed up but not yet renewed
        // Separate counts for auto and manual assignments
        $autoFollowup = GpsFollowup::select('gps_followup.gps_id')
            ->join('gps_summery', 'gps_followup.gps_id', '=', 'gps_summery.id')
            ->whereIn('gps_followup.gps_id', function($query) use ($callcenterId) {
                $query->select('gps_id')
                    ->from('abc_gps_auto_assignments')
                    ->where('status', 'active')
                    ->when($callcenterId, function($q) use ($callcenterId) {
                        $q->where('callcenter_id', $callcenterId);
                    });
            })
            ->where('gps_summery.pay_status', '!=', 1)
            ->whereNull('gps_followup.deleted_at')
            ->distinct()
            ->count('gps_followup.gps_id');
        
        $manualFollowup = GpsFollowup::select('gps_followup.gps_id')
            ->join('gps_summery', 'gps_followup.gps_id', '=', 'gps_summery.id')
            ->whereIn('gps_followup.gps_id', function($query) use ($callcenterId) {
                $query->select('gps_id')
                    ->from('sales_imei_assign')
                    ->whereNull('deleted_at')
                    ->when($callcenterId, function($q) use ($callcenterId) {
                        $q->where('callcenter_id', $callcenterId);
                    })
                    ->whereNotIn('gps_id', function($q) {
                        $q->select('gps_id')
                            ->from('abc_gps_auto_assignments')
                            ->whereIn('status', ['active', 'escalated']);
                    });
            })
            ->where('gps_summery.pay_status', '!=', 1)
            ->whereNull('gps_followup.deleted_at')
            ->distinct()
            ->count('gps_followup.gps_id');
        
        $pendingFollowup = $autoFollowup + $manualFollowup;
        
        $autoCompletedToday = GpsAutoAssignment::where('status', 'completed')
            ->when($callcenterId, function($query) use ($callcenterId) {
                $query->where('callcenter_id', $callcenterId);
            })
            ->whereDate('completed_at', today())
            ->whereHas('gps', function($query) {
                $query->where('pay_status', 1)
                      ->whereDate('pay_date', today());
            })
            ->count();
        
        // Regular sales assignments (not in automation system)
        $regularAssignedCount = SalesAssignGps::whereNull('deleted_at')
            ->when($callcenterId, function($query) use ($callcenterId) {
                $query->where('callcenter_id', $callcenterId);
            })
            ->whereHas('gps', function($query) {
                $query->where('pay_status', '!=', 1);
            })
            ->whereNotIn('gps_id', function($query) {
                $query->select('gps_id')
                    ->from('abc_gps_auto_assignments')
                    ->whereIn('status', ['active', 'escalated']);
            })
            ->count();
        
        // Regular assignments completed today (using gps_summery)
        $regularCompletedToday = Gps::where('pay_status', 1)
            ->whereDate('pay_date', today())
            ->whereIn('id', function($query) use ($callcenterId) {
                $query->select('gps_id')
                    ->from('sales_imei_assign')
                    ->whereNull('deleted_at')
                    ->when($callcenterId, function($q) use ($callcenterId) {
                        $q->where('callcenter_id', $callcenterId);
                    });
            })
            ->whereNotIn('id', function($query) {
                $query->select('gps_id')
                    ->from('abc_gps_auto_assignments')
                    ->where('status', 'completed')
                    ->whereDate('completed_at', today());
            })
            ->count();
        
        // Pending assignments: GPS devices not yet assigned to call centers
        // GPS where pay_status != 1 and not in sales_imei_assign or abc_gps_auto_assignments
        $pendingAssignments = Gps::where('pay_status', '!=', 1)
            ->whereNotIn('id', function($query) {
                $query->select('gps_id')
                    ->from('sales_imei_assign')
                    ->whereNull('deleted_at');
            })
            ->whereNotIn('id', function($query) {
                $query->select('gps_id')
                    ->from('abc_gps_auto_assignments')
                    ->whereIn('status', ['active', 'escalated']);
            })
            ->count();
        
        // Calculate today's revenue from gps_summery
        $todaysRevenue = Gps::where('pay_status', 1)
            ->whereDate('pay_date', today())
            ->when($callcenterId, function($query) use ($callcenterId) {
                $query->whereIn('id', function($q) use ($callcenterId) {
                    $q->select('gps_id')
                        ->from('sales_imei_assign')
                        ->where('callcenter_id', $callcenterId)
                        ->whereNull('deleted_at')
                        ->union(
                            \DB::table('abc_gps_auto_assignments')
                                ->select('gps_id')
                                ->where('callcenter_id', $callcenterId)
                                ->whereIn('status', ['active', 'completed', 'escalated'])
                        );
                });
            })
            ->sum('amount');
        
        $stats = [
            'pending_assignments' => $pendingAssignments,
            'assigned' => $autoAssignedActive + $regularAssignedCount,
            'total_assigned' => $autoAssignedActive + $regularAssignedCount,
            'urgent_count' => $autoAssignedUrgent,
            'pending_followup' => $pendingFollowup,
            'completed_today' => $autoCompletedToday + $regularCompletedToday,
            'month_revenue' => $todaysRevenue,
            'todays_revenue' => $todaysRevenue,
            'unread_notifications' => Auth::check() 
                ? RenewalNotification::unreadCountForUser(Auth::id())
                : 0,
            'callcenter_stats' => $callcenterId ? [] : $this->getCallCenterStats(),
        ];
        
        return response()->json([
            'success' => true,
            'stats' => $stats,
        ]);
        } catch (\Throwable $e) {
            \Log::error('RenewalAutomation getStats ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Get per-call-center statistics
     * Combines automated and regular assignments
     */
    protected function getCallCenterStats(){
        $callcenters = Callcenter::whereNull('deleted_at')->get();
        $stats = [];
        
        foreach ($callcenters as $cc) {
            // Automated assignments
            $autoActive = GpsAutoAssignment::where('callcenter_id', $cc->id)
                ->where('status', 'active')
                ->whereHas('gps', function($query) {
                    $query->where('pay_status', '!=', 1);
                })
                ->count();
            
            // Pending follow-up for this call center: followed up (by anyone) but not renewed
            // Separate counts for auto and manual assignments
            $ccAutoFollowup = GpsFollowup::select('gps_followup.gps_id')
                ->join('gps_summery', 'gps_followup.gps_id', '=', 'gps_summery.id')
                ->whereIn('gps_followup.gps_id', function($query) use ($cc) {
                    $query->select('gps_id')
                        ->from('abc_gps_auto_assignments')
                        ->where('callcenter_id', $cc->id)
                        ->where('status', 'active');
                })
                ->where('gps_summery.pay_status', '!=', 1)
                ->whereNull('gps_followup.deleted_at')
                ->distinct()
                ->count('gps_followup.gps_id');
            
            $ccManualFollowup = GpsFollowup::select('gps_followup.gps_id')
                ->join('gps_summery', 'gps_followup.gps_id', '=', 'gps_summery.id')
                ->whereIn('gps_followup.gps_id', function($query) use ($cc) {
                    $query->select('gps_id')
                        ->from('sales_imei_assign')
                        ->where('callcenter_id', $cc->id)
                        ->whereNull('deleted_at')
                        ->whereNotIn('gps_id', function($q) {
                            $q->select('gps_id')
                                ->from('abc_gps_auto_assignments')
                                ->whereIn('status', ['active', 'escalated']);
                        });
                })
                ->where('gps_summery.pay_status', '!=', 1)
                ->whereNull('gps_followup.deleted_at')
                ->distinct()
                ->count('gps_followup.gps_id');
            
            $ccPending = $ccAutoFollowup + $ccManualFollowup;
            
            $autoCompleted = GpsAutoAssignment::where('callcenter_id', $cc->id)
                ->where('status', 'completed')
                ->whereDate('completed_at', today())
                ->whereHas('gps', function($query) {
                    $query->where('pay_status', 1)
                          ->whereDate('pay_date', today());
                })
                ->count();
            
            // Regular assignments (not in automation)
            $regularActive = SalesAssignGps::where('callcenter_id', $cc->id)
                ->whereNull('deleted_at')
                ->whereHas('gps', function($query) {
                    $query->where('pay_status', '!=', 1);
                })
                ->whereNotIn('gps_id', function($query) {
                    $query->select('gps_id')
                        ->from('abc_gps_auto_assignments')
                        ->whereIn('status', ['active', 'escalated']);
                })
                ->count();
            
            // Regular completed today by this call center (using gps_summery)
            $regularCompleted = Gps::where('pay_status', 1)
                ->whereDate('pay_date', today())
                ->whereIn('id', function($query) use ($cc) {
                    $query->select('gps_id')
                        ->from('sales_imei_assign')
                        ->where('callcenter_id', $cc->id)
                        ->whereNull('deleted_at');
                })
                ->whereNotIn('id', function($query) {
                    $query->select('gps_id')
                        ->from('abc_gps_auto_assignments')
                        ->where('status', 'completed')
                        ->whereDate('completed_at', today());
                })
                ->count();
            
            $stats[] = [
                'id' => $cc->id,
                'name' => $cc->name,
                'active' => $autoActive + $regularActive,
                'pending_followup' => $ccPending,
                'completed_today' => $autoCompleted + $regularCompleted,
            ];
        }
        
        return $stats;
    }
    
    /**
     * Get sales users for notifications
     */
    protected function getSalesUsers(){
        // Adjust based on your user role system
        return \App\Modules\User\Models\User::where('role', 'sales')
            ->orWhere('role', 'admin')
            ->get();
    }
    
    /**
     * Mark GPS as completed (called when renewal is done)
     * This should be called from the renewal completion process
     */
    public function markGpsCompleted($gpsId){
        $assignment = GpsAutoAssignment::where('gps_id', $gpsId)
            ->whereIn('status', ['active', 'escalated'])
            ->first();
        
        if ($assignment) {
            DB::beginTransaction();
            try {
                $assignment->markCompleted();
                
                // Soft delete the sales_imei_assign record
                SalesAssignGps::where('gps_id', $gpsId)
                    ->whereNull('deleted_at')
                    ->update(['deleted_at' => now()]);
                
                GpsAssignmentLog::logCompletion(
                    $assignment->id,
                    $gpsId,
                    $assignment->callcenter_id
                );
                
                DB::commit();
                return true;
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Failed to mark GPS {$gpsId} as completed: " . $e->getMessage());
                return false;
            }
        }
        
        return false;
    }
    
    /**
     * Manual reassignment of GPS to different call center
     */
    public function manualReassign(Request $request){
        // Logging disabled for manual reassignment to avoid storage write errors
        
        $request->validate([
            'assignment_id' => 'required',
            'new_callcenter_id' => 'required|integer',
            'reason' => 'nullable|string|max:500',
        ]);
        
        try {
            // Check if this is a regular assignment (prefixed with 'regular_')
            $assignmentId = $request->assignment_id;
            $isRegular = is_string($assignmentId) && strpos($assignmentId, 'regular_') === 0;
            
            // assignment type info suppressed
            
            if ($isRegular) {
                // Extract numeric ID from 'regular_123' format
                $numericId = str_replace('regular_', '', $assignmentId);
                // processing regular assignment (logging suppressed)
                
                // Find the regular assignment in sales_imei_assign
                $salesAssignment = SalesAssignGps::findOrFail($numericId);
                $oldCallcenterId = $salesAssignment->callcenter_id;
                $newCallcenterId = $request->new_callcenter_id;
                
                if ($oldCallcenterId == $newCallcenterId) {
                    \Log::warning('Same call center selected');
                    return response()->json([
                        'success' => false,
                        'message' => 'GPS is already assigned to this call center.',
                    ]);
                }
                
                // Update the regular assignment
                $salesAssignment->callcenter_id = $newCallcenterId;
                $salesAssignment->updated_at = now(); // Update timestamp to current date
                $salesAssignment->save();
                
                // regular assignment updated (logging suppressed)
                
                $oldCallcenter = Callcenter::find($oldCallcenterId);
                $newCallcenter = Callcenter::find($newCallcenterId);
                
                return response()->json([
                    'success' => true,
                    'message' => "GPS reassigned from {$oldCallcenter->name} to {$newCallcenter->name}",
                ]);
            }
            
            // Handle automated assignment
            $assignment = GpsAutoAssignment::findOrFail($assignmentId);
            $oldCallcenterId = $assignment->callcenter_id;
            $newCallcenterId = $request->new_callcenter_id;
            
            // processing auto assignment (logging suppressed)
            
            
            if ($oldCallcenterId == $newCallcenterId) {
                return response()->json([
                    'success' => false,
                    'message' => 'GPS is already assigned to this call center.',
                ]);
            }
            
            DB::beginTransaction();
            
            // Update auto assignment
            $assignment->callcenter_id = $newCallcenterId;
            $assignment->reassignment_count = 0; // Reset count for manual assignment
            $assignment->status = 'active'; // Back to active
            $assignment->escalated_to_sales = 0;
            $assignment->escalation_date = null;
            $assignment->assignment_date = now();
            $assignment->expected_followup_by = now()->addDays(config('renewal_automation.followup_wait_days', 3));
            $assignment->followup_completed = false;
            $assignment->followup_completed_at = null;
            $assignment->save();
            
            // Update sales_imei_assign table
            SalesAssignGps::where('gps_id', $assignment->gps_id)
                ->where('callcenter_id', $oldCallcenterId)
                ->whereNull('deleted_at')
                ->update([
                    'callcenter_id' => $newCallcenterId,
                    'updated_at' => now() // Update timestamp to current date
                ]);
            
            // Log manual reassignment
            GpsAssignmentLog::logManualReassignment(
                $assignment->id,
                $assignment->gps_id,
                $oldCallcenterId,
                $newCallcenterId,
                Auth::id(),
                $request->reason ?? 'Manually reassigned by sales user'
            );
            
            DB::commit();
            
            $oldCallcenter = Callcenter::find($oldCallcenterId);
            $newCallcenter = Callcenter::find($newCallcenterId);
            
            // auto assignment updated successfully (logging suppressed)
            
            return response()->json([
                'success' => true,
                'message' => "GPS reassigned from {$oldCallcenter->name} to {$newCallcenter->name}",
            ]);
            
        } catch (\Exception $e) {
            DB::rollBack();
            // error details suppressed to avoid writing to log files
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reassign GPS: ' . $e->getMessage(),
            ], 500);
        }
    }
    
    /**
     * Redirect to GPS details page with encrypted ID
     */
    public function redirectToGpsDetails($id)
    {
        $encryptedId = \Crypt::encrypt($id);
        return redirect("/gps/{$encryptedId}/details");
    }
}