<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - <?= esc($name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
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
            <?php elseif ($role === 'instructor'): ?>
                <!-- Instructor Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="bi bi-person-badge"></i> Instructor Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-warning">
                                        <div class="card-body text-center">
                                            <i class="bi bi-book fs-1 text-warning"></i>
                                            <h5 class="mt-2">My Courses</h5>
                                            <p class="text-muted">Manage your courses and materials</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="bi bi-people fs-1 text-info"></i>
                                            <h5 class="mt-2">Students</h5>
                                            <p class="text-muted">View and manage your students</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="bi bi-clipboard-check fs-1 text-success"></i>
                                            <h5 class="mt-2">Assignments</h5>
                                            <p class="text-muted">Grade and review assignments</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php elseif ($role === 'student'): ?>
                <!-- Student Dashboard Content -->
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-mortarboard"></i> Student Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card border-success">
                                        <div class="card-body text-center">
                                            <i class="bi bi-book fs-1 text-success"></i>
                                            <h5 class="mt-2">My Courses</h5>
                                            <p class="text-muted">View your enrolled courses</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body text-center">
                                            <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                                            <h5 class="mt-2">Assignments</h5>
                                            <p class="text-muted">Submit and track assignments</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card border-info">
                                        <div class="card-body text-center">
                                            <i class="bi bi-graph-up fs-1 text-info"></i>
                                            <h5 class="mt-2">Grades</h5>
                                            <p class="text-muted">View your grades and progress</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
</body>
</html>

