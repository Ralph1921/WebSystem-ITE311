<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WebSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #2f4154 !important; }
        .navbar-brand { color: #fff !important; font-weight: 600; }
        .navbar-nav .nav-link { color: rgba(255,255,255,0.75) !important; }
        .navbar-nav .nav-link:hover { color: white !important; }
        .main-content { background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 3rem; margin-top: 2rem; }
        .stats-card { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 10px; padding: 2rem; }
        .welcome-section { background: linear-gradient(135deg, #2f4154 0%, #1e2933 100%); color: white; border-radius: 10px; padding: 2rem; margin-bottom: 2rem; }
        .btn-logout { background-color: #dc3545; border-color: #dc3545; }
        .btn-logout:hover { background-color: #c82333; border-color: #bd2130; }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">WebSystem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?= base_url('/dashboard') ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">Home</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> <?= $user['name'] ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= base_url('/logout') ?>"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Welcome Section -->
                <div class="welcome-section">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h1 class="mb-2">Welcome back, <?= $user['name'] ?>!</h1>
                            <p class="mb-0">You are successfully logged in to your dashboard.</p>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <div class="badge bg-light text-dark fs-6 px-3 py-2">
                                <?= ucfirst($user['role']) ?> Account
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information Card -->
                <div class="main-content">
                    <div class="row">
                        <div class="col-md-8">
                            <h3 class="mb-4">Account Information</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="text-muted mb-2">Full Name</h6>
                                        <p class="mb-0 fw-bold"><?= $user['name'] ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="text-muted mb-2">Email Address</h6>
                                        <p class="mb-0 fw-bold"><?= $user['email'] ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="text-muted mb-2">User ID</h6>
                                        <p class="mb-0 fw-bold">#<?= $user['id'] ?></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="border rounded p-3">
                                        <h6 class="text-muted mb-2">Account Role</h6>
                                        <span class="badge bg-primary fs-6"><?= ucfirst($user['role']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-center">
                                <h4 class="mb-3">Quick Actions</h4>
                                <div class="d-grid gap-2">
                                    <a href="#" class="btn btn-light btn-lg">Edit Profile</a>
                                    <a href="#" class="btn btn-outline-light btn-lg">Change Password</a>
                                    <a href="<?= base_url('/logout') ?>" class="btn btn-logout btn-lg">
                                        <i class="fas fa-sign-out-alt"></i> Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Section -->
                <div class="main-content">
                    <h3 class="mb-4">Recent Activity</h3>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <h5 class="alert-heading">Welcome to WebSystem!</h5>
                                <p class="mb-0">This is your protected dashboard. Only authenticated users can access this page.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="mt-5 py-4" style="background:#2f4154;color:#fff;">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 WebSystem - Secure Authentication System</p>
        </div>
    </footer>

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
