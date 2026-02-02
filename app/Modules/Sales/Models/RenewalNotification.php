<?php

namespace App\Modules\Sales\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\User\Models\User;
use App\Modules\Gps\Models\Gps;

class RenewalNotification extends Model
{
    protected $table = 'abc_renewal_notifications';
    
    protected $fillable = [
        'user_id',
        'gps_id',
        'gps_auto_assignment_id',
        'notification_type',
        'title',
        'message',
        'icon',
        'priority',
        'is_read',
        'read_at',
    ];
    
    protected $dates = [
        'read_at',
        'created_at',
        'updated_at',
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
    ];
    
    // ========== RELATIONSHIPS ==========
    
    /**
     * Get the user who received this notification
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Get the GPS device
     */
    public function gps()
    {
        return $this->belongsTo(Gps::class, 'gps_id');
    }
    
    /**
     * Get the related auto assignment
     */
    public function autoAssignment()
    {
        return $this->belongsTo(GpsAutoAssignment::class, 'gps_auto_assignment_id');
    }
    
    // ========== SCOPES ==========
    
    /**
     * Scope for unread notifications
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', 0);
    }
    
    /**
     * Scope for read notifications
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', 1);
    }
    
    /**
     * Scope for specific user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
    
    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('notification_type', $type);
    }
    
    /**
     * Scope for urgent notifications
     */
    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }
    
    /**
     * Scope for recent notifications (last 7 days)
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }
    
    // ========== HELPER METHODS ==========
    
    /**
     * Mark notification as read
     */
    public function markAsRead()
    {
        if (!$this->is_read) {
            $this->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }
    }
    
    /**
     * Mark notification as unread
     */
    public function markAsUnread()
    {
        $this->update([
            'is_read' => false,
            'read_at' => null,
        ]);
    }
    
    /**
     * Get icon class for display
     */
    public function getIconClassAttribute()
    {
        $icons = [
            'auto_assigned' => 'fa-robot',
            'reassignment' => 'fa-exchange-alt',
            'escalation' => 'fa-exclamation-triangle',
            'renewal_due' => 'fa-calendar-times',
        ];
        
        return $icons[$this->notification_type] ?? 'fa-bell';
    }
    
    /**
     * Get priority badge color
     */
    public function getPriorityColorAttribute()
    {
        return [
            'low' => 'secondary',
            'medium' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
        ][$this->priority] ?? 'secondary';
    }
    
    /**
     * Get time ago string
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
    
    // ========== STATIC HELPER METHODS ==========
    
    /**
     * Create notification for auto-assignment
     */
    public static function createAutoAssigned($userId, $gpsId, $assignmentId, $callcenterName)
    {
        return self::create([
            'user_id' => $userId,
            'gps_id' => $gpsId,
            'gps_auto_assignment_id' => $assignmentId,
            'notification_type' => 'auto_assigned',
            'title' => 'GPS Auto-Assigned',
            'message' => "GPS device automatically assigned to {$callcenterName} for renewal follow-up.",
            'icon' => 'robot',
            'priority' => 'low',
        ]);
    }
    
    /**
     * Create notification for reassignment
     */
    public static function createReassignment($userId, $gpsId, $assignmentId, $fromCallcenter, $toCallcenter, $attempt)
    {
        return self::create([
            'user_id' => $userId,
            'gps_id' => $gpsId,
            'gps_auto_assignment_id' => $assignmentId,
            'notification_type' => 'reassignment',
            'title' => 'GPS Reassigned',
            'message' => "GPS device reassigned from {$fromCallcenter} to {$toCallcenter} (Attempt {$attempt}/3) due to no follow-up.",
            'icon' => 'exchange-alt',
            'priority' => 'medium',
        ]);
    }
    
    /**
     * Create notification for escalation
     */
    public static function createEscalation($userId, $gpsId, $assignmentId, $imei)
    {
        return self::create([
            'user_id' => $userId,
            'gps_id' => $gpsId,
            'gps_auto_assignment_id' => $assignmentId,
            'notification_type' => 'escalation',
            'title' => 'URGENT: GPS Escalated',
            'message' => "GPS device (IMEI: {$imei}) escalated to sales after 3 failed follow-up attempts. Immediate action required!",
            'icon' => 'exclamation-triangle',
            'priority' => 'urgent',
        ]);
    }
    
    /**
     * Get unread count for user
     */
    public static function unreadCountForUser($userId)
    {
        return self::where('user_id', $userId)
                   ->where('is_read', 0)
                   ->count();
    }
    
    /**
     * Get urgent count for user
     */
    public static function urgentCountForUser($userId)
    {
        return self::where('user_id', $userId)
                   ->where('is_read', 0)
                   ->where('priority', 'urgent')
                   ->count();
    }
}
