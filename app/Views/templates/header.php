<?php
// Get user role from session
$role = session()->get('role') ?? 'guest';
$name = session()->get('name') ?? 'User';
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= site_url('dashboard') ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if ($role === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard') ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/users') ?>">
                            <i class="bi bi-people"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/settings') ?>">
                            <i class="bi bi-gear"></i> Settings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('admin/reports') ?>">
                            <i class="bi bi-graph-up"></i> Reports
                        </a>
                    </li>
                <?php elseif ($role === 'instructor' || $role === 'teacher'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard') ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('instructor/courses') ?>">
                            <i class="bi bi-book"></i> My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('instructor/students') ?>">
                            <i class="bi bi-people"></i> Students
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('instructor/assignments') ?>">
                            <i class="bi bi-clipboard-check"></i> Assignments
                        </a>
                    </li>
                <?php elseif ($role === 'student'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('dashboard') ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('student/courses') ?>">
                            <i class="bi bi-book"></i> My Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('student/assignments') ?>">
                            <i class="bi bi-file-earmark-text"></i> Assignments
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('student/grades') ?>">
                            <i class="bi bi-graph-up"></i> Grades
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= site_url('/') ?>">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php if (session()->get('isLoggedIn')): ?>
                    <!-- Notifications Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-bell"></i> Notifications
                            <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="notificationBadge" style="display: none;">
                                <span id="unreadCount">0</span>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="min-width: 350px;">
                            <div style="max-height: 400px; overflow-y: auto;">
                                <ul id="notificationList" style="list-style: none; margin: 0; padding: 0;">
                                    <li><a class="dropdown-item text-muted text-center py-3"><small>Loading notifications...</small></a></li>
                                </ul>
                            </div>
                            <hr class="dropdown-divider m-0">
                            <button class="dropdown-item text-center py-2 text-primary w-100" id="markAllReadBtn" onclick="markAllAsRead()" style="cursor: pointer; border: none; background: none;">
                                <i class="bi bi-check-all"></i> Mark all as read
                            </button>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <span class="nav-link text-white">
                        <i class="bi bi-person-circle"></i> <?= esc($name) ?>
                    </span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?= site_url('logout') ?>">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

