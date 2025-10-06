<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Debug</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>🐛 Dashboard Debug Version</h1>
        
        <div class="alert alert-success">
            <h3>✅ SUCCESS - This is your dashboard!</h3>
            <h4>Welcome, <?= esc($user['email']) ?>!</h4>
        </div>
        
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-info">
                <strong>Flash Message:</strong> <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>👤 User Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> <?= esc($user['id']) ?></p>
                        <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
                        <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                        <p><strong>Role:</strong> <?= esc($user['role']) ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>🔧 Debug Information</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Session ID:</strong> <?= session_id() ?></p>
                        <p><strong>Logged In:</strong> <?= session()->get('logged_in') ? 'Yes' : 'No' ?></p>
                        <p><strong>Time:</strong> <?= date('Y-m-d H:i:s') ?></p>
                        <p><strong>Base URL:</strong> <?= base_url() ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <h3>🚨 Comparison Test</h3>
            <p>If you can see this dashboard debug page, but NOT the regular dashboard, the problem is:</p>
            <ul>
                <li>❌ The main layout template (<code>layouts/main.php</code>) has an issue</li>
                <li>❌ CSS or JavaScript is preventing display</li>
                <li>❌ The view templating system has a problem</li>
            </ul>
            
            <div class="alert alert-warning">
                <h4>🎯 Solution:</h4>
                <p>Try the <strong>Simple Dashboard</strong> which bypasses the complex layout:</p>
                <a href="<?= base_url('/dashboard-simple') ?>" class="btn btn-primary">Go to Simple Dashboard</a>
            </div>
        </div>

        <div class="mt-4">
            <h3>🔗 Navigation</h3>
            <a href="<?= base_url('/') ?>" class="btn btn-secondary">Home</a>
            <a href="<?= base_url('/dashboard') ?>" class="btn btn-info">Regular Dashboard</a>
            <a href="<?= base_url('/dashboard-simple') ?>" class="btn btn-success">Simple Dashboard</a>
            <a href="<?= base_url('/logout') ?>" class="btn btn-danger">Logout</a>
        </div>

        <div class="mt-4">
            <h3>📊 All Session Data</h3>
            <pre class="bg-light p-3"><?= print_r(session()->get(), true) ?></pre>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>