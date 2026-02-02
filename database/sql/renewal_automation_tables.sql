-- ============================================================
-- GPS Renewal Auto-Assignment System - Database Tables
-- Created: 2026-01-29
-- Prefix: abc_
-- ============================================================

-- Table 1: GPS Auto Assignments
-- Purpose: Track all auto-assigned GPS devices through lifecycle
CREATE TABLE IF NOT EXISTS `abc_gps_auto_assignments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gps_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to gps_summery.id',
  `callcenter_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to callcenters.id',
  
  -- Assignment tracking
  `assigned_by_system` tinyint(1) DEFAULT 1 COMMENT '1=auto, 0=manual',
  `assignment_date` datetime NOT NULL COMMENT 'When assignment was created',
  `expected_followup_by` datetime NOT NULL COMMENT 'assignment_date + 3 days',
  `followup_completed` tinyint(1) DEFAULT 0 COMMENT 'Has any follow-up been done',
  `followup_completed_at` datetime DEFAULT NULL COMMENT 'When follow-up was completed',
  
  -- Escalation tracking
  `reassignment_count` tinyint(4) DEFAULT 0 COMMENT 'Number of reassignments (max 3)',
  `escalated_to_sales` tinyint(1) DEFAULT 0 COMMENT '1=escalated to sales dashboard',
  `escalation_date` datetime DEFAULT NULL COMMENT 'When escalated',
  
  -- Status management
  `status` enum('active','completed','escalated','skipped') DEFAULT 'active' COMMENT 'Current status',
  `completed_at` datetime DEFAULT NULL COMMENT 'When GPS was renewed',
  
  -- Metadata
  `last_checked_at` datetime DEFAULT NULL COMMENT 'Last time checked by system',
  `notes` text DEFAULT NULL COMMENT 'Additional notes',
  
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Auto-assignment tracking for GPS renewals';


-- Table 2: Renewal Notifications
-- Purpose: In-app notifications for sales users
CREATE TABLE IF NOT EXISTS `abc_renewal_notifications` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to users.id (sales user)',
  `gps_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to gps_summery.id',
  `gps_auto_assignment_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Foreign key to abc_gps_auto_assignments.id',
  
  -- Notification content
  `notification_type` enum('reassignment','escalation','renewal_due','auto_assigned') NOT NULL COMMENT 'Type of notification',
  `title` varchar(255) NOT NULL COMMENT 'Notification title',
  `message` text NOT NULL COMMENT 'Notification message body',
  
  -- Display metadata
  `icon` varchar(50) DEFAULT 'bell' COMMENT 'Icon name for UI',
  `priority` enum('low','medium','high','urgent') DEFAULT 'medium' COMMENT 'Display priority',
  
  -- Status
  `is_read` tinyint(1) DEFAULT 0 COMMENT '0=unread, 1=read',
  `read_at` datetime DEFAULT NULL COMMENT 'When notification was read',
  
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Notification system for renewal management';


-- Table 3: GPS Assignment Logs
-- Purpose: Audit trail of all assignment changes
CREATE TABLE IF NOT EXISTS `abc_gps_assignment_logs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `gps_auto_assignment_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to abc_gps_auto_assignments.id',
  `gps_id` bigint(20) UNSIGNED NOT NULL COMMENT 'Foreign key to gps_summery.id',
  
  -- Assignment change details
  `from_callcenter_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'Previous call center (NULL for first assignment)',
  `to_callcenter_id` bigint(20) UNSIGNED NOT NULL COMMENT 'New call center',
  
  -- Action details
  `action` enum('initial_assign','reassign','escalate','manual_reassign','completed') NOT NULL COMMENT 'Type of action',
  `reason` text DEFAULT NULL COMMENT 'Reason for action',
  
  -- Who made the change
  `created_by_system` tinyint(1) DEFAULT 1 COMMENT '1=automatic, 0=manual by user',
  `created_by_user_id` bigint(20) UNSIGNED DEFAULT NULL COMMENT 'User ID if manual action',
  
  -- Metadata
  `reassignment_attempt` tinyint(4) DEFAULT 0 COMMENT 'Which attempt number (0-3)',
  
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='Audit trail for GPS assignment changes';


-- ============================================================
-- INDEXES AND FOREIGN KEYS (Optional - uncomment if needed)
-- ============================================================

-- Note: Foreign key constraints commented out to avoid dependency issues
-- Uncomment only if your database structure supports it

/*
ALTER TABLE `abc_gps_auto_assignments`
  ADD CONSTRAINT `fk_abc_gps_auto_gps` 
    FOREIGN KEY (`gps_id`) REFERENCES `gps_summery`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_gps_auto_callcenter` 
    FOREIGN KEY (`callcenter_id`) REFERENCES `callcenters`(`id`) ON DELETE CASCADE;

ALTER TABLE `abc_renewal_notifications`
  ADD CONSTRAINT `fk_abc_notif_user` 
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_notif_gps` 
    FOREIGN KEY (`gps_id`) REFERENCES `gps_summery`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_notif_assignment` 
    FOREIGN KEY (`gps_auto_assignment_id`) REFERENCES `abc_gps_auto_assignments`(`id`) ON DELETE SET NULL;

ALTER TABLE `abc_gps_assignment_logs`
  ADD CONSTRAINT `fk_abc_log_assignment` 
    FOREIGN KEY (`gps_auto_assignment_id`) REFERENCES `abc_gps_auto_assignments`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_log_gps` 
    FOREIGN KEY (`gps_id`) REFERENCES `gps_summery`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_log_from_callcenter` 
    FOREIGN KEY (`from_callcenter_id`) REFERENCES `callcenters`(`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `fk_abc_log_to_callcenter` 
    FOREIGN KEY (`to_callcenter_id`) REFERENCES `callcenters`(`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_abc_log_user` 
    FOREIGN KEY (`created_by_user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL;
*/


-- ============================================================
-- SAMPLE QUERIES FOR TESTING
-- ============================================================

-- Check tables created successfully
-- SHOW TABLES LIKE 'abc_%';

-- View table structure
-- DESCRIBE abc_gps_auto_assignments;
-- DESCRIBE abc_renewal_notifications;
-- DESCRIBE abc_gps_assignment_logs;

-- Count records (should be 0 initially)
-- SELECT COUNT(*) FROM abc_gps_auto_assignments;
-- SELECT COUNT(*) FROM abc_renewal_notifications;
-- SELECT COUNT(*) FROM abc_gps_assignment_logs;
