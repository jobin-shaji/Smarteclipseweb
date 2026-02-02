<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Gps\Models\Gps;
use App\Modules\Sales\Models\Callcenter;

class GpsAutoAssignment extends Model
{
    protected $table = 'abc_gps_auto_assignments';
    
    protected $fillable = [
        'gps_id',
        'callcenter_id',
        'assigned_by_system',
        'assignment_date',
        'expected_followup_by',
        'followup_completed',
        'followup_completed_at',
        'reassignment_count',
        'escalated_to_sales',
        'escalation_date',
        'status',
        'completed_at',
        'last_checked_at',
        'notes',
    ];
    
    protected $dates = [
        'assignment_date',
        'expected_followup_by',
        'followup_completed_at',
        'escalation_date',
        'completed_at',
        'last_checked_at',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'assigned_by_system' => 'boolean',
        'followup_completed' => 'boolean',
        'escalated_to_sales' => 'boolean',
        'reassignment_count' => 'integer',
    ];
    
    // ========== RELATIONSHIPS ==========
    
    /**
     * Get the GPS device
     */
    public function gps()
    {
        return $this->belongsTo(Gps::class, 'gps_id', 'id');
    }
    
    /**
     * Get the assigned call center
     */
    public function callcenter()
    {
        return $this->belongsTo(Callcenter::class, 'callcenter_id', 'id');
    }
    
    /**
     * Get assignment logs
     */
    public function logs()
    {
        return $this->hasMany(GpsAssignmentLog::class, 'gps_auto_assignment_id');
    }
    
    /**
     * Get notifications related to this assignment
     */
    public function notifications()
    {
        return $this->hasMany(RenewalNotification::class, 'gps_auto_assignment_id');
    }
    
    // ========== SCOPES ==========
    
    /**
     * Scope for active assignments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    
    /**
     * Scope for escalated assignments
     */
    public function scopeEscalated($query)
    {
        return $query->where('escalated_to_sales', 1)
                     ->where('status', 'escalated');
    }
    
    /**
     * Scope for overdue follow-ups
     */
    public function scopeOverdueFollowup($query)
    {
        return $query->where('status', 'active')
                     ->where('followup_completed', 0)
                     ->where('expected_followup_by', '<', now());
    }
    
    /**
     * Scope for completed assignments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
    
    // ========== HELPER METHODS ==========
    
    /**
     * Check if assignment is overdue for follow-up
     */
    public function isOverdueFollowup()
    {
        return $this->status === 'active' 
            && !$this->followup_completed 
            && $this->expected_followup_by < now();
    }
    
    /**
     * Check if assignment can be reassigned
     */
    public function canReassign()
    {
        return $this->status === 'active' 
            && $this->reassignment_count < config('renewal_automation.max_reassignment_attempts', 3);
    }
    
    /**
     * Check if assignment should be escalated
     */
    public function shouldEscalate()
    {
        return $this->status === 'active' 
            && $this->reassignment_count >= config('renewal_automation.max_reassignment_attempts', 3)
            && !$this->escalated_to_sales;
    }
    
    /**
     * Mark assignment as completed
     */
    public function markCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
    
    /**
     * Mark follow-up as completed
     */
    public function markFollowupCompleted()
    {
        $this->update([
            'followup_completed' => true,
            'followup_completed_at' => now(),
        ]);
    }
    
    /**
     * Escalate to sales
     */
    public function escalate()
    {
        $this->update([
            'status' => 'escalated',
            'escalated_to_sales' => true,
            'escalation_date' => now(),
        ]);
    }
    
    /**
     * Get days remaining until expiry
     */
    public function getDaysRemainingAttribute()
    {
        if (!$this->gps || !$this->gps->validity_date) {
            return null;
        }
        
        return now()->diffInDays($this->gps->validity_date, false);
    }
    
    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return [
            'active' => 'primary',
            'completed' => 'success',
            'escalated' => 'danger',
            'skipped' => 'secondary',
        ][$this->status] ?? 'secondary';
    }
    
    /**
     * Get priority level
     */
    public function getPriorityAttribute()
    {
        if ($this->escalated_to_sales) {
            return 'urgent';
        }
        
        $daysRemaining = $this->days_remaining;
        
        if ($daysRemaining <= 7) {
            return 'high';
        } elseif ($daysRemaining <= 15) {
            return 'medium';
        }
        
        return 'low';
    }
}
