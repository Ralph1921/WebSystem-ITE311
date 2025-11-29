<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= esc($name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        .notification-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }
        
        .notification-toast {
            min-width: 300px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            border: none;
            border-radius: 8px;
            margin-bottom: 10px;
            animation: slideIn 0.3s ease-in-out;
        }
        
        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        
        .notification-toast.success {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            color: #155724;
        }
        
        .notification-toast.error {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            color: #721c24;
        }
        
        .notification-toast.info {
            background-color: #d1ecf1;
            border-left: 4px solid #17a2b8;
            color: #0c5460;
        }
        
        .notification-toast .close-btn {
            cursor: pointer;
            font-size: 18px;
            opacity: 0.7;
            transition: opacity 0.2s;
        }
        
        .notification-toast .close-btn:hover {
            opacity: 1;
        }
    </style>
</head>
<body>
    <?php echo view('templates/header'); ?>

    <!-- Notification Container -->
    <div class="notification-container" id="notificationContainer"></div>

    <div class="container mt-4">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Welcome Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body bg-primary text-white rounded">
                        <h2 class="card-title mb-0">
                            <i class="bi bi-person-badge"></i> Welcome, <?= esc($name) ?>!
                        </h2>
                        <p class="card-text mt-2 mb-0">You are logged in as <strong><?= esc(ucfirst($role)) ?></strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Information Card -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="bi bi-person-circle"></i> User Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong><i class="bi bi-person"></i> Name:</strong></td>
                                <td><?= esc($name) ?></td>
                            </tr>
                            <tr>
                                <td><strong><i class="bi bi-envelope"></i> Email:</strong></td>
                                <td><?= esc($email) ?></td>
                            </tr>
                            <tr>
                                <td><strong><i class="bi bi-shield-check"></i> Role:</strong></td>
                                <td>
                                    <span class="badge bg-<?= $role === 'admin' ? 'danger' : ($role === 'instructor' ? 'warning' : ($role === 'student' ? 'success' : ($role === 'user' ? 'primary' : 'secondary'))) ?>">
                                        <?= esc(ucfirst($role)) ?>
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning-charge"></i> Quick Actions</h5>
                    </div>
                        <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= site_url('/') ?>" class="btn btn-outline-primary">
                                <i class="bi bi-house"></i> Go to Homepage
                            </a>
                            <a href="<?= site_url('courses') ?>" class="btn btn-outline-secondary">
                                <i class="bi bi-search"></i> Browse Courses
                            </a>
                            <a href="<?= site_url('logout') ?>" class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </a>
                        </div>
                        </div>
                </div>
            </div>
        </div>

        <!-- Role-Based Content -->
        <div class="row">
            <?php if ($role === 'admin'): ?>
                <!-- Admin Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0"><i class="bi bi-shield-lock"></i> Admin Panel</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people fs-1 text-primary"></i>
                                            <h5 class="mt-2">User Management</h5>
                                            <p class="text-muted">Manage all users in the system</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="bi bi-gear fs-1 text-success"></i>
                                            <h5 class="mt-2">System Settings</h5>
                                            <p class="text-muted">Configure system preferences</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="bi bi-graph-up fs-1 text-info"></i>
                                            <h5 class="mt-2">Reports & Analytics</h5>
                                            <p class="text-muted">View system reports and statistics</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'instructor' || $role === 'teacher'): ?>
                <!-- Instructor/Teacher Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-book"></i> My Courses</h5>
                            <div class="d-flex align-items-center gap-2">
                                <a href="<?= site_url('courses') ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-search"></i> Browse Courses
                                </a>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                    <i class="bi bi-plus-circle"></i> Create Course
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $my_courses = $my_courses ?? []; ?>
                            <?php if (!empty($my_courses)): ?>
                                <div class="row">
                                    <?php foreach ($my_courses as $course): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title'] ?? 'N/A') ?></h5>
                                                    <p class="card-text"><?= esc($course['description'] ?? '') ?></p>
                                                    <small class="text-muted">ID: <?= $course['id'] ?></small>
                                                    <div class="mt-3">
                                                        <a href="<?= site_url('course/' . $course['id'] . '/upload') ?>" class="btn btn-sm btn-info">
                                                            <i class="bi bi-cloud-arrow-up"></i> Upload Materials
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle"></i> You haven't created any courses yet. Click "Create Course" to get started.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Create Course Modal -->
                <div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCourseModalLabel">Create New Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= site_url('course/create') ?>" method="post">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="courseTitle" class="form-label">Course Title</label>
                                        <input type="text" class="form-control" id="courseTitle" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="courseDescription" class="form-label">Course Description</label>
                                        <textarea class="form-control" id="courseDescription" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create Course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'teacher'): ?>
                <!-- Teacher Dashboard Content (same as instructor) -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-book"></i> My Courses</h5>
                            <div class="d-flex align-items-center gap-2">
                                <a href="<?= site_url('courses') ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-search"></i> Browse Courses
                                </a>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createCourseModal">
                                    <i class="bi bi-plus-circle"></i> Create Course
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <?php $my_courses = $my_courses ?? []; ?>
                            <?php if (!empty($my_courses)): ?>
                                <div class="row">
                                    <?php foreach ($my_courses as $course): ?>
                                        <div class="col-md-6 mb-3">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title'] ?? 'N/A') ?></h5>
                                                    <p class="card-text"><?= esc($course['description'] ?? '') ?></p>
                                                    <small class="text-muted">ID: <?= $course['id'] ?></small>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle"></i> You haven't created any courses yet. Click "Create Course" to get started.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Create Course Modal -->
                <div class="modal fade" id="createCourseModal" tabindex="-1" aria-labelledby="createCourseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="createCourseModalLabel">Create New Course</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="<?= site_url('course/create') ?>" method="post">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="courseTitle" class="form-label">Course Title</label>
                                        <input type="text" class="form-control" id="courseTitle" name="title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="courseDescription" class="form-label">Course Description</label>
                                        <textarea class="form-control" id="courseDescription" name="description" rows="3" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Create Course</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'student'): ?>
                <!-- Student Dashboard Content -->
                <!-- Enrolled Courses Section -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-book"></i> Enrolled Courses</h5>
                        </div>
                        <div class="card-body">
                            <?php $enrolled_courses = $enrolled_courses ?? []; ?>
                            <?php if (!empty($enrolled_courses)): ?>
                                <div class="list-group">
                                    <?php foreach ($enrolled_courses as $course): ?>
                                        <div class="list-group-item">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1"><?= esc($course['title'] ?? 'N/A') ?></h5>
                                                <small><?= isset($course['enrollment_date']) ? date('M d, Y', strtotime($course['enrollment_date'])) : 'N/A' ?></small>
                                            </div>
                                            <p class="mb-1"><?= esc($course['description'] ?? '') ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">You are not enrolled in any courses yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Course Materials Section -->
                <div class="col-12 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-file-earmark-pdf"></i> Course Materials</h5>
                        </div>
                        <div class="card-body">
                            <?php $course_materials = $course_materials ?? []; ?>
                            <?php if (!empty($course_materials)): ?>
                                <?php foreach ($course_materials as $course_id => $data_materials): ?>
                                    <div class="mb-4">
                                        <h6 class="text-primary mb-3"><i class="bi bi-book"></i> <?= esc($data_materials['course_title']) ?></h6>
                                        <div class="list-group">
                                            <?php foreach ($data_materials['materials'] as $material): ?>
                                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <i class="bi bi-file"></i> <?= esc($material['file_name']) ?>
                                                        </h6>
                                                        <small class="text-muted">
                                                            Uploaded: <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                    <a href="<?= site_url('materials/download/' . $material['id']) ?>" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-cloud-arrow-down"></i> Download
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <hr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-muted"><i class="bi bi-info-circle"></i> No materials available for your enrolled courses yet.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Available Courses Section -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Available Courses</h5>
                            <a href="<?= site_url('courses') ?>" class="btn btn-sm btn-outline-light">
                                <i class="bi bi-search"></i> Search Courses
                            </a>
                        </div>
                        <div class="card-body">
                            <?php $available_courses = $available_courses ?? []; ?>
                            <?php if (!empty($available_courses)): ?>
                                <div class="row" id="available-courses-container">
                                    <?php foreach ($available_courses as $course): ?>
                                        <div class="col-md-6 mb-3" id="course-<?= $course['id'] ?>">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title'] ?? 'N/A') ?></h5>
                                                    <p class="card-text"><?= esc($course['description'] ?? '') ?></p>
                                                    <button class="btn btn-primary enroll-btn" data-course-id="<?= $course['id'] ?>">
                                                        <i class="bi bi-plus-circle"></i> Enroll
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No available courses at this time.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'user'): ?>
                <!-- Regular User Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-person"></i> User Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body text-center">
                                            <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                            <h5 class="mt-2">My Profile</h5>
                                            <p class="text-muted">View and edit your profile information</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="bi bi-book fs-1 text-success"></i>
                                            <h5 class="mt-2">My Content</h5>
                                            <p class="text-muted">Access your personal content</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="bi bi-bell fs-1 text-info"></i>
                                            <h5 class="mt-2">Notifications</h5>
                                            <p class="text-muted">Check your notifications</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <!-- Default/Other Roles Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-secondary text-white">
                            <h5 class="mb-0"><i class="bi bi-grid"></i> Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <p>Welcome to your dashboard. Your role is: <strong><?= esc(ucfirst($role)) ?></strong></p>
                            <p>This is a unified dashboard that adapts based on your user role.</p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Footer -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center text-muted">
                        <small>
                            <i class="bi bi-calendar"></i> Last login: <?= date('F d, Y h:i A') ?> | 
                            <i class="bi bi-shield-check"></i> Secure Session
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Notification Helper Function
        function showNotification(message, type = 'success', duration = 4000) {
            var icons = {
                'success': 'bi-check-circle',
                'error': 'bi-exclamation-circle',
                'info': 'bi-info-circle'
            };
            
            var notificationHtml = '<div class="notification-toast ' + type + '" id="notification-' + Date.now() + '">' +
                '<div class="d-flex align-items-center justify-content-between p-3">' +
                '<div class="d-flex align-items-center">' +
                '<i class="bi ' + icons[type] + ' me-2" style="font-size: 1.2rem;"></i>' +
                '<span class="notification-message">' + message + '</span>' +
                '</div>' +
                '<span class="close-btn" onclick="$(this).closest(\'.notification-toast\').fadeOut(300, function() { $(this).remove(); })">&times;</span>' +
                '</div>' +
                '</div>';
            
            var notifId = '#notification-' + Date.now();
            $('#notificationContainer').append(notificationHtml);
            
            // Auto-remove after duration
            setTimeout(function() {
                $(notifId).fadeOut(300, function() { $(this).remove(); });
            }, duration);
        }

        // Load notifications from server
        function loadNotifications() {
            $.get('<?= site_url('/notifications') ?>', function(response) {
                if (response.success) {
                    updateNotificationBadge(response.unread_count);
                    updateNotificationList(response.notifications);
                }
            }, 'json').fail(function(error) {
                console.error('Failed to load notifications:', error);
            });
        }

        // Update the badge count
        function updateNotificationBadge(count) {
            var badge = $('#notificationBadge');
            var countEl = $('#unreadCount');
            
            if (count > 0) {
                countEl.text(count);
                badge.show();
            } else {
                badge.hide();
            }
        }

        // Update the notification list
        function updateNotificationList(notifications) {
            var notificationList = $('#notificationList');
            
            if (notifications.length === 0) {
                notificationList.html('<li><a class="dropdown-item text-muted text-center py-3"><small>No notifications</small></a></li>');
                return;
            }

            var html = '';
            notifications.forEach(function(notif) {
                var readClass = notif.is_read ? 'list-group-item-light' : 'list-group-item-info';
                var createdDate = new Date(notif.created_at);
                var timeAgo = getTimeAgo(createdDate);
                
                html += '<li>';
                html += '<div class="dropdown-item ' + readClass + ' p-3 border-bottom">';
                html += '<div class="d-flex justify-content-between align-items-start">';
                html += '<div class="flex-grow-1">';
                html += '<p class="mb-1">' + notif.message + '</p>';
                html += '<small class="text-muted">' + timeAgo + '</small>';
                html += '</div>';
                if (!notif.is_read) {
                    html += '<button class="btn btn-sm btn-light ms-2" onclick="markAsRead(' + notif.id + ')" title="Mark as read">';
                    html += '<i class="bi bi-check2"></i>';
                    html += '</button>';
                }
                html += '</div>';
                html += '</div>';
                html += '</li>';
            });
            
            notificationList.html(html);
        }

        // Mark notification as read
        function markAsRead(notificationId) {
            $.post('<?= site_url('/notifications/mark_read/') ?>' + notificationId, function(response) {
                if (response.success) {
                    loadNotifications();
                }
            }, 'json');
        }

        // Mark all notifications as read
        function markAllAsRead() {
            $.post('<?= site_url('/notifications/mark_all_read') ?>', function(response) {
                if (response.success) {
                    loadNotifications();
                    showNotification('All notifications marked as read', 'success');
                }
            }, 'json').fail(function(error) {
                console.error('Failed to mark all as read:', error);
            });
        }

        // Helper function to get time ago string
        function getTimeAgo(date) {
            var seconds = Math.floor((new Date() - date) / 1000);
            
            if (seconds < 60) return 'Just now';
            
            var intervals = {
                'year': 31536000,
                'month': 2592000,
                'week': 604800,
                'day': 86400,
                'hour': 3600,
                'minute': 60
            };
            
            for (var key in intervals) {
                var interval = Math.floor(seconds / intervals[key]);
                if (interval >= 1) {
                    return interval + ' ' + key + (interval > 1 ? 's' : '') + ' ago';
                }
            }
            return 'Just now';
        }

        $(document).ready(function() {
            // Load notifications when page loads
            if ($('#notificationDropdown').length > 0) {
                console.log('Notifications dropdown found, loading notifications...');
                loadNotifications();
                // Refresh notifications every 30 seconds
                setInterval(loadNotifications, 30000);
            }

            $('.enroll-btn').on('click', function(e) {
                e.preventDefault();
                
                var button = $(this);
                var courseId = button.data('course-id');
                var courseCard = $('#course-' + courseId);
                
                // Disable button during request
                button.prop('disabled', true);
                button.html('<i class="bi bi-hourglass-split"></i> Enrolling...');
                
                $.post('<?= site_url("/course/enroll") ?>', {
                    course_id: courseId
                }, function(response) {
                    if (response.success) {
                        // Show success notification
                        showNotification(response.message, 'success');
                        
                        // Reload notifications to show new enrollment notification
                        setTimeout(function() {
                            loadNotifications();
                        }, 500);
                        
                        // Get the enrolled courses card body
                        var enrolledCard = $('.card-header').filter(function() {
                            return $(this).text().includes('Enrolled Courses');
                        }).closest('.card');
                        
                        var enrolledCardBody = enrolledCard.find('.card-body');
                        
                        // Check if list group exists
                        var enrolledListGroup = enrolledCardBody.find('.list-group');
                        
                        if (enrolledListGroup.length === 0) {
                            // Create list group if it doesn't exist
                            var newListGroup = '<div class="list-group"></div>';
                            enrolledCardBody.html(newListGroup);
                            enrolledListGroup = enrolledCardBody.find('.list-group');
                        }
                        
                        // Course data from response
                        var course = response.course;
                        var enrollmentDate = new Date(course.enrollment_date);
                        var formattedDate = enrollmentDate.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
                        
                        // Create new enrolled course item
                        var enrolledItem = '<div class="list-group-item">' +
                            '<div class="d-flex w-100 justify-content-between">' +
                            '<h5 class="mb-1">' + course.title + '</h5>' +
                            '<small>' + formattedDate + '</small>' +
                            '</div>' +
                            '<p class="mb-1">' + course.description + '</p>' +
                            '</div>';
                        
                        // Add to enrolled courses
                        enrolledListGroup.append(enrolledItem);
                        
                        // Remove the course from available courses
                        var courseCard = $('#course-' + courseId);
                        courseCard.fadeOut(300, function() {
                            $(this).remove();
                            
                            // Check if there are no more available courses
                            var remainingCourses = $('#available-courses-container .col-md-6').length;
                            if (remainingCourses === 0) {
                                // Add no courses message
                                var noCourseMsg = '<p class="text-muted">No available courses at this time.</p>';
                                $('#available-courses-container').replaceWith(noCourseMsg);
                            }
                        });
                    } else {
                        // Show error notification
                        showNotification(response.message, 'error', 5000);
                        
                        // Re-enable button on error
                        button.prop('disabled', false);
                        button.html('<i class="bi bi-plus-circle"></i> Enroll');
                    }
                }, 'json').fail(function(jqXHR, textStatus, errorThrown) {
                    var errorMsg = 'An error occurred while enrolling.';
                    if (jqXHR.status === 401) {
                        errorMsg = 'You must be logged in to enroll.';
                    } else if (jqXHR.status === 400) {
                        try {
                            var response = JSON.parse(jqXHR.responseText);
                            errorMsg = response.message || errorMsg;
                        } catch(e) {}
                    }
                    
                    showNotification(errorMsg, 'error', 5000);
                    
                    // Re-enable button on error
                    button.prop('disabled', false);
                    button.html('<i class="bi bi-plus-circle"></i> Enroll');
                });
            });
        });
        
    </script>
</body>
</html>

