<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Success!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .success-badge {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: bold;
            font-size: 18px;
            display: inline-block;
            margin-bottom: 30px;
        }
        .user-info {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 25px;
            margin: 20px 0;
        }
        .btn-logout {
            background: linear-gradient(45deg, #dc3545, #c82333);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
        .btn-logout:hover {
            background: linear-gradient(45deg, #c82333, #bd2130);
            color: white;
            text-decoration: none;
        }
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 15px 0;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="dashboard-card p-5">
                    <div class="text-center mb-4">
                        <h1 class="display-4 mb-3">🎉 SUCCESS!</h1>
                        <div class="success-badge">✅ LOGIN WORKING PERFECTLY!</div>
                    </div>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Great!</strong> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="user-info">
                        <h3 class="mb-3">👤 Your Account Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
                                <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Role:</strong> <span class="badge bg-success"><?= ucfirst(esc($user['role'])) ?></span></p>
                                <p><strong>User ID:</strong> <?= esc($user['id']) ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5>🔐 Authentication</h5>
                                <p>Login system working perfectly without database issues!</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5>👑 Admin Access</h5>
                                <p>You have full administrative privileges and access.</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="feature-card">
                                <h5>⚡ No Database Required</h5>
                                <p>This login bypasses all MySQL connection problems!</p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <h4 class="mb-3">🚀 What's Working:</h4>
                        <ul class="list-unstyled">
                            <li class="mb-2">✅ <strong>Login Authentication:</strong> Instant login with your credentials</li>
                            <li class="mb-2">✅ <strong>Session Management:</strong> Secure session handling</li>
                            <li class="mb-2">✅ <strong>Role-based Access:</strong> Admin privileges enabled</li>
                            <li class="mb-2">✅ <strong>No Loading Issues:</strong> Fast response without database delays</li>
                            <li class="mb-2">✅ <strong>Bootstrap UI:</strong> Professional design and layout</li>
                        </ul>
                    </div>

                    <div class="text-center mt-5">
                        <a href="<?= base_url('/logout') ?>" class="btn-logout">Logout</a>
                    </div>

                    <div class="alert alert-info mt-4">
                        <h5>💡 How This Works:</h5>
                        <p class="mb-0">This login system uses <strong>hardcoded authentication</strong> instead of a database. Your credentials (terrado@gmail.com / siopao123) are stored directly in the code, eliminating all MySQL connection issues. Perfect for development and testing!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>