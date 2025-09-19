<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - WebSystem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .navbar { background-color: #2f4154 !important; }
        .navbar-brand { color: #fff !important; font-weight: 600; letter-spacing: .3px; }
        .navbar-nav .nav-link { color: rgba(255,255,255,0.75) !important; }
        .navbar-nav .nav-link:hover, .navbar-nav .nav-link.active { color: white !important; }
        .main-content { background-color: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 3rem; margin-top: 2rem; }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">WebSystem</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto gap-2">
                    <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="<?= base_url('index.php/about') ?>">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('index.php/contact') ?>">Contact</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="main-content">

    <h1 class="mb-4">About Us</h1>
    <p><strong>Mission:</strong> We strive to provide the best services to our customers and ensure satisfaction in every project we undertake.</p>
    <p><strong>Vision:</strong> Our team consists of dedicated professionals with expertise in various fields, working together to achieve excellence.</p>

    <h3 class="mt-5">Our Team</h3>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Team Member</h5>
                    <h6 class="text-muted">Position</h6>
                    <p>Short description about the team member.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Team Member</h5>
                    <h6 class="text-muted">Position</h6>
                    <p>Short description about the team member.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Team Member</h5>
                    <h6 class="text-muted">Position</h6>
                    <p>Short description about the team member.</p>
                </div>
            </div>
        </div>
    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-5 py-4" style="background:#2f4154;color:#fff;">
        <div class="container text-center">&copy; 2025 My Website</div>
    </footer>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
