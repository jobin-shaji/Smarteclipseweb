<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Gps\Models\Gps;
use App\Modules\Sales\Models\Callcenter;
use App\Modules\User\Models\User;

class GpsAssignmentLog extends Model
{
    protected $table = 'abc_gps_assignment_logs';
    
    public $timestamps = false; // Only created_at
    
    protected $fillable = [
        'gps_auto_assignment_id',
        'gps_id',
        'from_callcenter_id',
        'to_callcenter_id',
        'action',
        'reason',
        'created_by_system',
        'created_by_user_id',
        'reassignment_attempt',
    ];
    
    protected $dates = [
        'created_at',
    ];
    
    protected $casts = [
        'created_by_system' => 'boolean',
        'reassignment_attempt' => 'integer',
    ];
    
    // ========== RELATIONSHIPS ==========
    
    /**
     * Get the auto assignment
     */
    public function autoAssignment()
    {
        return $this->belongsTo(GpsAutoAssignment::class, 'gps_auto_assignment_id');
    }
    
    /**
     * Get the GPS device
     */
    public function gps()
    {
        return $this->belongsTo(Gps::class, 'gps_id');
    }
    
    /**
     * Get the source call center
     */
    public function fromCallcenter()
    {
        return $this->belongsTo(Callcenter::class, 'from_callcenter_id');
    }
    
    /**
     * Get the destination call center
     */
    public function toCallcenter()
    {
        return $this->belongsTo(Callcenter::class, 'to_callcenter_id');
    }
    
    /**
     * Get the user who made the change (if manual)
     */
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }
    
    // ========== SCOPES ==========
    
    /**
     * Scope for specific GPS
     */
    public function scopeForGps($query, $gpsId)
    {
        return $query->where('gps_id', $gpsId);
    }
    
    /**
     * Scope for specific action
     */
    public function scopeAction($query, $action)
    {
        return $query->where('action', $action);
    }
    
    /**
     * Scope for system-created logs
     */
    public function scopeSystemCreated($query)
    {
        return $query->where('created_by_system', 1);
    }
    
    /**
     * Scope for user-created logs
     */
    public function scopeUserCreated($query)
    {
        return $query->where('created_by_system', 0);
    }
    
    /**
     * Scope for recent logs
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
    
    // ========== HELPER METHODS ==========
    
    /**
     * Get action label
     */
    public function getActionLabelAttribute()
    {
        return [
            'initial_assign' => 'Initial Assignment',
            'reassign' => 'Reassignment',
            'escalate' => 'Escalation',
            'manual_reassign' => 'Manual Reassignment',
            'completed' => 'Completed',
        ][$this->action] ?? $this->action;
    }
    
    /**
     * Get action color
     */
    public function getActionColorAttribute()
    {
        return [
            'initial_assign' => 'primary',
            'reassign' => 'warning',
            'escalate' => 'danger',
            'manual_reassign' => 'info',
            'completed' => 'success',
        ][$this->action] ?? 'secondary';
    }
    
    /**
     * Get who created this log
     */
    public function getCreatedByTextAttribute()
    {
        if ($this->created_by_system) {
            return 'System (Automatic)';
        }
        
        if ($this->createdByUser) {
            return $this->createdByUser->username;
        }
        
        return 'Unknown';
    }
    
    // ========== STATIC HELPER METHODS ==========
    
    /**
     * Log initial assignment
     */
    public static function logInitialAssignment($assignmentId, $gpsId, $callcenterId)
    {
        return self::create([
            'gps_auto_assignment_id' => $assignmentId,
            'gps_id' => $gpsId,
            'from_callcenter_id' => null,
            'to_callcenter_id' => $callcenterId,
            'action' => 'initial_assign',
            'reason' => 'Auto-assigned based on last renewal history',
            'created_by_system' => true,
            'reassignment_attempt' => 0,
        ]);
    }
    
    /**
     * Log reassignment
     */
    public static function logReassignment($assignmentId, $gpsId, $fromCallcenterId, $toCallcenterId, $attempt)
    {
        return self::create([
            'gps_auto_assignment_id' => $assignmentId,
            'gps_id' => $gpsId,
            'from_callcenter_id' => $fromCallcenterId,
            'to_callcenter_id' => $toCallcenterId,
            'action' => 'reassign',
            'reason' => "No follow-up within 3 days (Attempt {$attempt}/3)",
            'created_by_system' => true,
            'reassignment_attempt' => $attempt,
        ]);
    }
    
    /**
     * Log escalation
     */
    public static function logEscalation($assignmentId, $gpsId, $callcenterId)
    {
        return self::create([
            'gps_auto_assignment_id' => $assignmentId,
            'gps_id' => $gpsId,
            'from_callcenter_id' => $callcenterId,
            'to_callcenter_id' => $callcenterId, // Stays with same call center
            'action' => 'escalate',
            'reason' => 'Escalated to sales after 3 failed follow-up attempts',
            'created_by_system' => true,
            'reassignment_attempt' => 3,
        ]);
    }
    
    /**
     * Log manual reassignment by user
     */
    public static function logManualReassignment($assignmentId, $gpsId, $fromCallcenterId, $toCallcenterId, $userId, $reason = null)
    {
        return self::create([
            'gps_auto_assignment_id' => $assignmentId,
            'gps_id' => $gpsId,
            'from_callcenter_id' => $fromCallcenterId,
            'to_callcenter_id' => $toCallcenterId,
            'action' => 'manual_reassign',
            'reason' => $reason ?? 'Manually reassigned by sales user',
            'created_by_system' => false,
            'created_by_user_id' => $userId,
            'reassignment_attempt' => 0, // Reset count on manual assignment
        ]);
    }
    
    /**
     * Log completion
     */
    public static function logCompletion($assignmentId, $gpsId, $callcenterId)
    {
        return self::create([
            'gps_auto_assignment_id' => $assignmentId,
            'gps_id' => $gpsId,
            'from_callcenter_id' => $callcenterId,
            'to_callcenter_id' => $callcenterId,
            'action' => 'completed',
            'reason' => 'GPS device renewed successfully',
            'created_by_system' => true,
            'reassignment_attempt' => 0,
        ]);
    }
}
