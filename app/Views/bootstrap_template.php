<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS Terrado - Learning Management System</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #2f4154 !important; }
        .navbar-brand { color: #fff !important; font-weight: 600; letter-spacing: .3px; }
        
        .navbar-nav .nav-link {
            color: rgba(255,255,255,0.75) !important;
        }
        
        .navbar-nav .nav-link:hover {
            color: white !important;
        }
        
        .main-content {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 3rem;
            margin-top: 2rem;
        }
        
        .content-title {
            color: #495057;
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 1rem;
        }
        
        .content-subtitle {
            color: #6c757d;
            font-size: 1rem;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">LMS Terrado</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url() ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/about') ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/contact') ?>">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('/register') ?>">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-content">
                    <h1 class="content-title">Welcome to LMS Terrado</h1>
                    <p class="content-subtitle">Learning Management System - Your gateway to educational excellence. Access courses, track your progress, and enhance your learning experience.</p>
                    <div class="mt-4 d-flex gap-3 justify-content-center">
                        <a href="<?= base_url('/login') ?>" class="btn btn-primary btn-lg">Login to Your Account</a>
                        <a href="<?= base_url('/register') ?>" class="btn btn-outline-primary btn-lg">Create New Account</a>
                    </div>
                    <div class="mt-4 d-flex gap-3 justify-content-center">
                        <a href="<?= base_url('/about') ?>" class="btn btn-secondary">Learn About Us</a>
                        <a href="<?= base_url('/contact') ?>" class="btn btn-outline-secondary">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4" style="background:#2f4154;color:#fff;">
        <div class="container text-center">&copy; 2025 LMS Terrado - Learning Management System</div>
    </footer>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
