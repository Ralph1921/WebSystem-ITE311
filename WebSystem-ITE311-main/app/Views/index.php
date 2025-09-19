<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to My Homepage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .welcome-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

    <!-- Navigation Links -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-nav">
                <a class="nav-link btn btn-primary me-2" href="<?= base_url('/') ?>">Home</a>
                <a class="nav-link btn btn-outline-light me-2" href="<?= base_url('/about') ?>">About</a>
                <a class="nav-link btn btn-outline-light" href="<?= base_url('/contact') ?>">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <div class="welcome-container">
        <div class="welcome-box">
            <h1 class="display-3 mb-4">Welcome to My Homepage</h1>
            <p class="lead mb-4">This is a CodeIgniter 4 Learning Management System</p>
            <p class="mb-4">Created by: TERRADO | ITE311 Student</p>
            <div class="mt-4">
                <a href="<?= base_url('/about') ?>" class="btn btn-light btn-lg me-3">Learn About Us</a>
                <a href="<?= base_url('/contact') ?>" class="btn btn-outline-light btn-lg">Contact Us</a>
            </div>
        </div>
    </div>

</body>
</html>
