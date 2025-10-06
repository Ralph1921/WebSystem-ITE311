<?php
// Direct dashboard test - bypassing CodeIgniter views
require_once __DIR__ . '/vendor/autoload.php';

// Start CodeIgniter bootstrap
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require_once __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();
require_once rtrim($paths->systemDirectory, '\\/') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

// Initialize CodeIgniter services
$app = Config\Services::codeigniter();
$app->initialize();

echo "<h1>🔍 Direct Dashboard Test</h1>";

// Get session service
$session = \Config\Services::session();

echo "<h2>Session Information:</h2>";
echo "<pre>";
print_r($session->get());
echo "</pre>";

$logged_in = $session->get('logged_in');
$email = $session->get('email');
$name = $session->get('name');

echo "<h2>Authentication Status:</h2>";
echo "<p><strong>Logged In:</strong> " . ($logged_in ? 'YES' : 'NO') . "</p>";
echo "<p><strong>Email:</strong> " . ($email ?: 'Not set') . "</p>";
echo "<p><strong>Name:</strong> " . ($name ?: 'Not set') . "</p>";

if ($logged_in && $email) {
    echo "<div style='background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; margin: 20px 0; border-radius: 5px;'>";
    echo "<h2>✅ SUCCESS!</h2>";
    echo "<h3>Welcome, $email!</h3>";
    echo "<p>This proves that:</p>";
    echo "<ul>";
    echo "<li>✅ Login is working correctly</li>";
    echo "<li>✅ Session data is being stored</li>";
    echo "<li>✅ CodeIgniter session is accessible</li>";
    echo "</ul>";
    echo "</div>";
    
    echo "<div style='background: #f8d7da; padding: 20px; border: 1px solid #f5c6cb; margin: 20px 0; border-radius: 5px;'>";
    echo "<h3>🚨 The Problem</h3>";
    echo "<p>Since this page shows the welcome message but your regular dashboard doesn't, the issue is likely:</p>";
    echo "<ul>";
    echo "<li>❌ Dashboard view template not rendering properly</li>";
    echo "<li>❌ CSS/JavaScript preventing display</li>";
    echo "<li>❌ Layout template issue</li>";
    echo "</ul>";
    echo "</div>";
} else {
    echo "<div style='background: #fff3cd; padding: 20px; border: 1px solid #ffeaa7; margin: 20px 0; border-radius: 5px;'>";
    echo "<h2>⚠️ NOT LOGGED IN</h2>";
    echo "<p>You need to login first:</p>";
    echo "<p><a href='simple_login_test.php'>Simple Login Test</a></p>";
    echo "<p><a href='http://localhost/ITE311-TERRADO/login'>CodeIgniter Login</a></p>";
    echo "</div>";
}

echo "<h2>🔗 Navigation:</h2>";
echo "<ul>";
echo "<li><a href='simple_login_test.php'>Simple Login Test</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/login'>CodeIgniter Login</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/dashboard'>CodeIgniter Dashboard</a></li>";
echo "<li><a href='LOGIN_TESTING_GUIDE.html'>Testing Guide</a></li>";
echo "</ul>";
?>