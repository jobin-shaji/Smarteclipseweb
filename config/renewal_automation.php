<?php

return [
    /*
    |--------------------------------------------------------------------------
    | GPS Renewal Auto-Assignment Configuration
    |--------------------------------------------------------------------------
    |
    | This file controls the automatic assignment of expiring GPS devices
    | to call centers for renewal follow-up.
    |
    */

    // ========== FEATURE TOGGLES ==========
    
    'enabled' => env('RENEWAL_AUTO_ASSIGN_ENABLED', true),
    
    
    // ========== TEST MODE SETTINGS ==========
    
    'test_mode' => env('RENEWAL_TEST_MODE', false),
    
    // Comma-separated GPS IDs for testing (e.g., "123,456,789")
    'test_gps_ids' => env('RENEWAL_TEST_GPS_IDS', ''),
    
    // Maximum devices to process per run in test mode
    'test_max_per_run' => 15,
    
    
    // ========== TIMING CONFIGURATIONS ==========
    
    // Look ahead period for expiring devices (days)
    'expiry_window_days' => env('RENEWAL_EXPIRY_WINDOW_DAYS', 30),

    // No minimum days until expiry (min limit removed)

    // Wait period before considering follow-up overdue (days)
    'followup_wait_days' => env('RENEWAL_FOLLOWUP_WAIT_DAYS', 3),

    // Maximum number of reassignment attempts before escalation
    'max_reassignment_attempts' => 3,


    // ========== ASSIGNMENT LOGIC ==========

    // Try to assign to the same call center that did last renewal
    'prefer_last_renewer' => env('RENEWAL_PREFER_LAST_RENEWER', true),

    // If last renewer not found, assign to call center with lowest pending count
    'fallback_to_lowest_count' => env('RENEWAL_FALLBACK_TO_LOWEST_COUNT', true),

    // Skip auto-assignment if GPS already manually assigned
    'skip_if_manually_assigned' => env('RENEWAL_SKIP_IF_MANUALLY_ASSIGNED', true),
    
    
    // ========== NOTIFICATION SETTINGS ==========
    
    // Send notification to sales when device is reassigned
    'notify_sales_on_reassignment' => true,
    
    // Send notification to sales when device is escalated
    'notify_sales_on_escalation' => true,
    
    // Notification priority levels
    'notification_priorities' => [
        'auto_assigned' => 'low',
        'reassignment' => 'medium',
        'renewal_due' => 'high',
        'escalation' => 'urgent',
    ],
    
    
    // ========== DATABASE TABLES ==========
    
    // Table names (with abc_ prefix)
    'tables' => [
        'auto_assignments' => 'abc_gps_auto_assignments',
        'notifications' => 'abc_renewal_notifications',
        'assignment_logs' => 'abc_gps_assignment_logs',
    ],
    
    
    // ========== LOGGING ==========
    
    'log_channel' => 'daily',
    
    // Enable verbose logging (detailed execution logs)
    'verbose_logging' => env('RENEWAL_VERBOSE_LOGS', false),
    
    // Log queries for debugging
    'log_queries' => env('RENEWAL_LOG_QUERIES', false),
    
    
    // ========== PERFORMANCE ==========
    
    // Batch size for processing GPS devices
    'batch_size' => 50,
    
    // Maximum execution time (seconds) - 0 for no limit
    'max_execution_time' => 300,
    
    
    // ========== CALL CENTER SELECTION ==========
    
    // Method for calculating pending count
    // Options: 'all_pending', 'auto_assigned_only', 'expiring_only'
    'pending_count_method' => 'all_pending',
    
    // Include devices in pending count calculation
    'include_in_pending_count' => [
        'manual_assignments' => true,
        'auto_assignments' => true,
        'pay_status_not_renewed' => true, // pay_status != 1
    ],
    
    
    // ========== FOLLOW-UP DETECTION ==========
    
    // Which activities count as valid follow-up
    'valid_followup_activities' => [
        'gps_followup_entry' => true,  // Entry in gps_followup table
        'sms_sent' => false,            // SMS logged (not tracked yet)
        'call_logged' => false,         // Call logged (not tracked yet)
    ],
    
    
    // ========== UI SETTINGS ==========
    
    // Widget display on sales dashboard
    'dashboard_widget' => [
        'enabled' => true,
        'collapsible' => true,
        'default_collapsed' => false,
        'refresh_interval' => 300, // seconds (5 minutes)
    ],
    
    // Urgent list display
    'urgent_list' => [
        'items_per_page' => 25,
        'show_days_remaining' => true,
        'highlight_critical_days' => 7, // Days - highlight if <= 7 days
    ],
    
    
    // ========== SAFETY & VALIDATION ==========
    
    // Prevent assignment if GPS is in these statuses
    'skip_gps_statuses' => [
        // 'status' => 0, // Disabled devices
        // 'is_returned' => 1, // Returned devices
    ],
    
    // Minimum days until expiry to consider for assignment (negative = already expired)
    // Set to large negative value to include all expired devices
    'min_days_until_expiry' => env('RENEWAL_MIN_DAYS_UNTIL_EXPIRY', 1),
    
    // Maximum days until expiry to consider for assignment
    'max_days_until_expiry' => 30,
];
