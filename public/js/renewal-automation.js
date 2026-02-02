/**
 * GPS Renewal Automation - Frontend JavaScript
 * Handles button clicks, AJAX calls, and UI updates
 */

(function() {
    'use strict';
    
    // Configuration
    const config = {
        refreshInterval: 300000, // 5 minutes in milliseconds
        autoRefresh: true,
    };
    
    // State
    let refreshTimer = null;
    
    // Initialize on document ready
    $(document).ready(function() {
        initializeWidget();
        loadStats();
        
        if (config.autoRefresh) {
            startAutoRefresh();
        }
    });
    
    /**
     * Initialize widget event listeners
     */
    function initializeWidget() {
        // Run Auto-Assignment Button
        $('#btn-run-assignment').on('click', function() {
            runAutoAssignment();
        });
        
        // Check Follow-ups Button
        $('#btn-check-followups').on('click', function() {
            checkFollowups();
        });
        
        // Pending Assignments Stat Card Click
        $('#pending-assignments-stat-card').on('click', function() {
            window.location.href = '/esim-renewal-pending';
        });
        
        // Active Assignments Stat Card Click - Redirect with filter
        $('#active-stat-card').on('click', function() {
            window.location.href = '/auto-assigned-renewals?status=active';
        });
        
        // Urgent Stat Card Click - Show Modal
        $('#urgent-stat-card').on('click', function() {
            showUrgentList();
        });
        
        // Pending Follow-up Stat Card Click - Redirect with filter
        $('#pending-stat-card').on('click', function() {
            window.location.href = '/auto-assigned-renewals?followup_status=pending';
        });
        
        // Completed Today Stat Card Click - Redirect with filter
        $('#completed-today-stat-card').on('click', function() {
            window.location.href = '/auto-assigned-renewals?status=completed';
        });
        
        // View All Assignments Button
        $('#btn-view-all').on('click', function() {
            window.location.href = '/auto-assigned-renewals';
        });
        
        // Refresh Stats Button
        $('#btn-refresh-stats').on('click', function() {
            loadStats();
        });
        
        // Show test mode badge if enabled
        if (window.RENEWAL_TEST_MODE) {
            $('#renewal-test-mode-badge').show();
        }
    }
    
    /**
     * Load statistics from server
     */
    function loadStats() {
        $.ajax({
            url: '/renewal-automation/stats',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    updateStats(response.stats);
                    updateLastUpdatedTime();
                }
            },
            error: function(xhr) {
                console.error('Failed to load stats:', xhr);
            }
        });
    }
    
    /**
     * Update statistics in UI
     */
    function updateStats(stats) {
        $('#stat-pending-assignments').text(stats.pending_assignments || 0);
        $('#stat-total-assigned').text(stats.total_assigned || 0);
        $('#stat-urgent-count').text(stats.urgent_count || 0);
        $('#stat-pending-followup').text(stats.pending_followup || 0);
        $('#stat-completed-today').text(stats.completed_today || 0);
        $('#urgent-badge').text(stats.urgent_count || 0);
        
        // Pulse animation for urgent count if > 0
        if (stats.urgent_count > 0) {
            $('#stat-urgent-count, #urgent-badge').addClass('pulse-animation');
        } else {
            $('#stat-urgent-count, #urgent-badge').removeClass('pulse-animation');
        }
        
        // Update call center performance table
        if (stats.callcenter_stats && stats.callcenter_stats.length > 0) {
            updateCallCenterTable(stats.callcenter_stats);
        }
    }
    
    /**
     * Update call center performance table
     */
    function updateCallCenterTable(callcenterStats) {
        const container = $('#callcenter-stats-container');
        container.empty();
        
        if (callcenterStats.length === 0) {
            container.append('<div class="text-center text-muted py-3">No data available</div>');
            return;
        }
        
        callcenterStats.forEach(function(cc) {
            const box = `
                <div class="callcenter-performance-box">
                    <div class="callcenter-name-box">
                        <i class="fas fa-headset mr-2"></i>
                        ${cc.name}
                    </div>
                    <div class="callcenter-stats-boxes">
                        <div class="callcenter-stat-item" data-cc-id="${cc.id}" data-type="active" title="Click to view assigned GPS for ${cc.name}">
                            <div class="callcenter-stat-value active">${cc.active || 0}</div>
                            <div class="callcenter-stat-label">Assigned</div>
                        </div>
                        <div class="callcenter-stat-item" data-cc-id="${cc.id}" data-type="pending" title="Click to view pending follow-ups for ${cc.name}">
                            <div class="callcenter-stat-value pending">${cc.pending_followup || 0}</div>
                            <div class="callcenter-stat-label">Pending Follow-up</div>
                        </div>
                        <div class="callcenter-stat-item" data-cc-id="${cc.id}" data-type="completed" title="Click to view completed renewals for ${cc.name}">
                            <div class="callcenter-stat-value completed">${cc.completed_today || 0}</div>
                            <div class="callcenter-stat-label">Completed Today</div>
                        </div>
                    </div>
                </div>
            `;
            container.append(box);
        });
        
        // Add click handlers to call center stat items
        $('.callcenter-stat-item').on('click', function() {
            const ccId = $(this).data('cc-id');
            const type = $(this).data('type');
            let url = '/auto-assigned-renewals?callcenter_id=' + ccId;
            
            if (type === 'active') {
                url += '&status=active';
            } else if (type === 'pending') {
                url += '&status=active&followup_status=pending';
            } else if (type === 'completed') {
                url += '&status=completed&date_filter=today';
            }
            
            window.location.href = url;
        });
    }
    
    /**
     * Update last updated timestamp
     */
    function updateLastUpdatedTime() {
        const now = new Date();
        const timeString = now.toLocaleTimeString();
        $('#last-updated-time').text(timeString);
    }
    
    /**
     * Run auto-assignment process
     */
    function runAutoAssignment() {
        const $btn = $('#btn-run-assignment');
        
        // Disable button and show loading state
        setButtonLoading($btn, true);
        
        $.ajax({
            url: '/renewal-automation/execute',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setButtonLoading($btn, false);
                
                if (response.success) {
                    showToast('success', 'Auto-Assignment Completed', response.message);
                    
                    // Show details if available
                    if (response.assigned > 0) {
                        showAssignmentDetails(response);
                    }
                    
                    // Reload stats
                    loadStats();
                } else {
                    showToast('error', 'Auto-Assignment Failed', response.message);
                }
            },
            error: function(xhr) {
                setButtonLoading($btn, false);
                const errorMsg = xhr.responseJSON?.message || 'An error occurred while running auto-assignment.';
                showToast('error', 'Error', errorMsg);
            }
        });
    }
    
    /**
     * Check follow-ups and escalate if needed
     */
    function checkFollowups() {
        const $btn = $('#btn-check-followups');
        
        setButtonLoading($btn, true);
        
        $.ajax({
            url: '/renewal-automation/check-followups',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                setButtonLoading($btn, false);
                
                if (response.success) {
                    showToast('success', 'Follow-up Check Completed', response.message);
                    
                    // Reload stats
                    loadStats();
                    
                    // Show urgent list if escalations occurred
                    if (response.escalated > 0) {
                        setTimeout(function() {
                            showUrgentList();
                        }, 1000);
                    }
                } else {
                    showToast('error', 'Follow-up Check Failed', response.message);
                }
            },
            error: function(xhr) {
                setButtonLoading($btn, false);
                const errorMsg = xhr.responseJSON?.message || 'An error occurred while checking follow-ups.';
                showToast('error', 'Error', errorMsg);
            }
        });
    }
    
    /**
     * Show urgent list modal
     */
    function showUrgentList() {
        $('#urgentListModal').modal('show');
        
        // Load urgent devices
        $.ajax({
            url: '/renewal-automation/urgent-list',
            method: 'GET',
            success: function(response) {
                if (response.success) {
                    renderUrgentList(response.data);
                }
            },
            error: function(xhr) {
                $('#urgent-list-container').html(
                    '<div class="empty-state">' +
                    '<i class="fas fa-exclamation-circle"></i>' +
                    '<h6>Failed to Load</h6>' +
                    '<p>Could not load urgent GPS devices.</p>' +
                    '</div>'
                );
            }
        });
    }
    
    /**
     * Render urgent list in modal
     */
    function renderUrgentList(data) {
        const container = $('#urgent-list-container');
        
        if (!data.data || data.data.length === 0) {
            container.html(
                '<div class="empty-state">' +
                '<i class="fas fa-check-circle"></i>' +
                '<h6>No Urgent Devices</h6>' +
                '<p>All GPS devices are being followed up properly.</p>' +
                '</div>'
            );
            return;
        }
        
        // Get list of call centers for dropdown
        let callCenterOptions = '';
        if (window.CALL_CENTERS && window.CALL_CENTERS.length > 0) {
            window.CALL_CENTERS.forEach(function(cc) {
                callCenterOptions += '<option value="' + cc.id + '">' + cc.name + '</option>';
            });
        }
        
        let html = '<table class="table table-hover urgent-list-table">';
        html += '<thead><tr>';
        html += '<th>GPS ID</th>';
        html += '<th>IMEI</th>';
        html += '<th>Current Call Center</th>';
        html += '<th>Escalated On</th>';
        html += '<th>Days Overdue</th>';
        html += '<th>Status</th>';
        html += '<th>Action</th>';
        html += '</tr></thead><tbody>';
        
        data.data.forEach(function(item) {
            const daysOverdue = calculateDaysOverdue(item.escalation_date);
            html += '<tr>';
            html += '<td><strong>' + item.gps_id + '</strong></td>';
            html += '<td>' + (item.gps?.imei || 'N/A') + '</td>';
            html += '<td>' + (item.callcenter?.name || 'N/A') + '</td>';
            html += '<td>' + formatDate(item.escalation_date) + '</td>';
            html += '<td><span class="badge badge-danger">' + daysOverdue + ' days</span></td>';
            html += '<td><span class="status-badge escalated">Escalated</span></td>';
            html += '<td>';
            html += '<button class="btn btn-sm btn-primary btn-reassign" data-assignment-id="' + item.id + '" data-gps-id="' + item.gps_id + '" data-current-cc="' + item.callcenter_id + '">';
            html += '<i class="fas fa-exchange-alt"></i> Reassign';
            html += '</button>';
            html += '</td>';
            html += '</tr>';
        });
        
        html += '</tbody></table>';
        
        // Pagination if available
        if (data.last_page > 1) {
            html += '<nav><ul class="pagination">';
            for (let i = 1; i <= data.last_page; i++) {
                html += '<li class="page-item ' + (i === data.current_page ? 'active' : '') + '">';
                html += '<a class="page-link" href="#">' + i + '</a></li>';
            }
            html += '</ul></nav>';
        }
        
        container.html(html);
        
        // Bind reassign button clicks
        $('.btn-reassign').on('click', function() {
            const assignmentId = $(this).data('assignment-id');
            const gpsId = $(this).data('gps-id');
            const currentCc = $(this).data('current-cc');
            showReassignModal(assignmentId, gpsId, currentCc);
        });
    }
    
    /**
     * Show reassign modal
     */
    function showReassignModal(assignmentId, gpsId, currentCc) {
        // Fetch call centers for dropdown
        $.ajax({
            url: '/callcenter-list',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                let options = '';
                if (response.data) {
                    response.data.forEach(function(cc) {
                        if (cc.id != currentCc) {
                            options += '<option value="' + cc.id + '">' + cc.name + '</option>';
                        }
                    });
                }
                
                const modalHtml = 
                    '<div class="modal fade" id="reassignModal" tabindex="-1">' +
                    '<div class="modal-dialog">' +
                    '<div class="modal-content">' +
                    '<div class="modal-header bg-primary text-white">' +
                    '<h5 class="modal-title">Reassign GPS ' + gpsId + '</h5>' +
                    '<button type="button" class="close text-white" data-dismiss="modal">&times;</button>' +
                    '</div>' +
                    '<div class="modal-body">' +
                    '<div class="form-group">' +
                    '<label>Select Call Center:</label>' +
                    '<select class="form-control" id="new-callcenter-select">' +
                    '<option value="">-- Select Call Center --</option>' +
                    options +
                    '</select>' +
                    '</div>' +
                    '<div class="form-group">' +
                    '<label>Reason (optional):</label>' +
                    '<textarea class="form-control" id="reassign-reason" rows="3" placeholder="Enter reason for reassignment..."></textarea>' +
                    '</div>' +
                    '</div>' +
                    '<div class="modal-footer">' +
                    '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>' +
                    '<button type="button" class="btn btn-primary" id="confirm-reassign">Reassign</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';
                
                // Remove existing modal if any
                $('#reassignModal').remove();
                
                // Add modal to body
                $('body').append(modalHtml);
                
                // Show modal
                $('#reassignModal').modal('show');
                
                // Bind confirm button
                $('#confirm-reassign').on('click', function() {
                    const newCallcenterId = $('#new-callcenter-select').val();
                    const reason = $('#reassign-reason').val();
                    
                    if (!newCallcenterId) {
                        alert('Please select a call center');
                        return;
                    }
                    
                    performReassignment(assignmentId, newCallcenterId, reason);
                });
            },
            error: function() {
                alert('Failed to load call centers. Please try again.');
            }
        });
    }
    
    /**
     * Perform manual reassignment
     */
    function performReassignment(assignmentId, newCallcenterId, reason) {
        const $btn = $('#confirm-reassign');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Reassigning...');
        
        $.ajax({
            url: '/renewal-automation/manual-reassign',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                assignment_id: assignmentId,
                new_callcenter_id: newCallcenterId,
                reason: reason
            },
            success: function(response) {
                if (response.success) {
                    showToast('success', 'Reassignment Successful', response.message);
                    $('#reassignModal').modal('hide');
                    
                    // Reload urgent list and stats
                    setTimeout(function() {
                        loadStats();
                        showUrgentList();
                    }, 500);
                } else {
                    showToast('error', 'Reassignment Failed', response.message);
                    $btn.prop('disabled', false).html('Reassign');
                }
            },
            error: function(xhr) {
                const errorMsg = xhr.responseJSON?.message || 'Failed to reassign GPS device.';
                showToast('error', 'Error', errorMsg);
                $btn.prop('disabled', false).html('Reassign');
            }
        });
    }
    
    /**
     * Show assignment details in modal or alert
     */
    function showAssignmentDetails(response) {
        if (!response.details || response.details.length === 0) return;
        
        let message = '<strong>Assigned GPS Devices:</strong><br>';
        response.details.slice(0, 5).forEach(function(detail) {
            if (detail.callcenter) {
                message += '• GPS ' + detail.gps_id + ' → ' + detail.callcenter + '<br>';
            }
        });
        
        if (response.details.length > 5) {
            message += '<small class="text-muted">... and ' + (response.details.length - 5) + ' more</small>';
        }
        
        showToast('info', 'Assignment Details', message, 8000);
    }
    
    /**
     * Set button loading state
     */
    function setButtonLoading($btn, loading) {
        if (loading) {
            $btn.prop('disabled', true);
            $btn.addClass('loading');
            $btn.find('i').removeClass().addClass('fas fa-spinner fa-spin');
        } else {
            $btn.prop('disabled', false);
            $btn.removeClass('loading');
            
            // Restore original icon
            const btnId = $btn.attr('id');
            let iconClass = 'fa-play-circle';
            if (btnId === 'btn-check-followups') iconClass = 'fa-sync-alt';
            else if (btnId === 'btn-view-urgent') iconClass = 'fa-list-ul';
            else if (btnId === 'btn-refresh-stats') iconClass = 'fa-redo';
            
            $btn.find('i').removeClass().addClass('fas ' + iconClass);
        }
    }
    
    /**
     * Show toast notification
     */
    function showToast(type, title, message, duration) {
        duration = duration || 5000;
        
        const iconMap = {
            success: 'fa-check-circle',
            error: 'fa-times-circle',
            warning: 'fa-exclamation-triangle',
            info: 'fa-info-circle'
        };
        
        const toast = $('<div class="toast-notification ' + type + '">' +
            '<div class="d-flex align-items-start">' +
            '<i class="fas ' + iconMap[type] + ' fa-2x mr-3"></i>' +
            '<div class="flex-grow-1">' +
            '<strong>' + title + '</strong><br>' +
            '<small>' + message + '</small>' +
            '</div>' +
            '</div>' +
            '</div>');
        
        $('body').append(toast);
        
        setTimeout(function() {
            toast.fadeOut(300, function() {
                $(this).remove();
            });
        }, duration);
    }
    
    /**
     * Start auto-refresh timer
     */
    function startAutoRefresh() {
        refreshTimer = setInterval(function() {
            loadStats();
        }, config.refreshInterval);
    }
    
    /**
     * Stop auto-refresh timer
     */
    function stopAutoRefresh() {
        if (refreshTimer) {
            clearInterval(refreshTimer);
            refreshTimer = null;
        }
    }
    
    /**
     * Calculate days overdue
     */
    function calculateDaysOverdue(escalationDate) {
        if (!escalationDate) return 0;
        const now = new Date();
        const escalated = new Date(escalationDate);
        const diffTime = Math.abs(now - escalated);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays;
    }
    
    /**
     * Format date for display
     */
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }
    
    // Stop auto-refresh when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopAutoRefresh();
        } else {
            if (config.autoRefresh) {
                startAutoRefresh();
                loadStats();
            }
        }
    });
    
})();
