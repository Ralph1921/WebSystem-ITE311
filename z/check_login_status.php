<?php
// Quick diagnostic script
require_once __DIR__ . '/vendor/autoload.php';

// Start CodeIgniter bootstrap
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once rtrim($paths->systemDirectory, '\\/') . DIRECTORY_SEPARATOR . 'bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

$app = Config\Services::codeigniter();
$app->initialize();

echo "<h1>🔍 Login Status Check</h1>";

$session = \Config\Services::session();
$sessionData = $session->get();

echo "<h2>Current Session Data:</h2>";
echo "<pre>" . print_r($sessionData, true) . "</pre>";

echo "<h2>Authentication Status:</h2>";
$logged_in = $session->get('logged_in');
$email = $session->get('email');

echo "<p><strong>Logged In:</strong> " . ($logged_in ? 'YES ✅' : 'NO ❌') . "</p>";
echo "<p><strong>Email:</strong> " . ($email ?: 'Not set') . "</p>";

if ($logged_in && $email) {
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>✅ You ARE logged in!</h3>";
    echo "<p>Welcome, <strong>$email</strong>!</p>";
    echo "<p>The dashboard should be working. Let's check what's happening...</p>";
    echo "</div>";
    
    echo "<h3>🔗 Test Links:</h3>";
    echo "<p><a href='http://localhost/ITE311-TERRADO/dashboard'>Go to Dashboard</a></p>";
    echo "<p><a href='http://localhost/ITE311-TERRADO/dashboard-simple'>Go to Simple Dashboard</a></p>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
    echo "<h3>❌ You are NOT logged in</h3>";
    echo "<p>You need to login first:</p>";
    echo "<p><a href='http://localhost/ITE311-TERRADO/login'>Go to Login Page</a></p>";
    echo "</div>";
}

echo "<h3>📊 Quick Actions:</h3>";
echo "<ul>";
echo "<li><a href='http://localhost/ITE311-TERRADO/login'>Login Page</a></li>";
echo "<li><a href='simple_login_test.php'>Simple Login Test</a></li>";
echo "<li><a href='reset_session.php'>Reset Session</a></li>";
echo "<li><a href='MASTER_TEST.html'>Master Test Page</a></li>";
echo "</ul>";
?>