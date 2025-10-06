<?php
// Simple test script to verify login flow
echo "<h1>Login Flow Test</h1>";

echo "<h2>Step 1: Test login form loads</h2>";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$login_page = curl_exec($ch);
curl_close($ch);

if (strpos($login_page, 'form') !== false) {
    echo "<p>✅ Login form loads correctly</p>";
} else {
    echo "<p>❌ Login form not found</p>";
}

echo "<h2>Step 2: Test dashboard without login (should redirect)</h2>";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/dashboard');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false);
curl_setopt($ch, CURLOPT_HEADER, true);
$result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p>HTTP Status: $http_code</p>";
if ($http_code >= 300 && $http_code < 400) {
    echo "<p>✅ Correctly redirects when not logged in</p>";
} else {
    echo "<p>❌ Should redirect but didn't (Status: $http_code)</p>";
}

echo "<h2>Manual Test Instructions</h2>";
echo "<ol>";
echo "<li><a href='http://localhost/ITE311-TERRADO/login' target='_blank'>Open Login Form</a></li>";
echo "<li>Enter email: <strong>terrado@gmail.com</strong></li>";
echo "<li>Enter password: <strong>siopao123</strong></li>";
echo "<li>Click login - should redirect to dashboard</li>";
echo "<li>Verify dashboard shows: 'Welcome, terrado@gmail.com!'</li>";
echo "</ol>";

echo "<p><strong>Test Links:</strong></p>";
echo '<ul>';
echo '<li><a href="http://localhost/ITE311-TERRADO/login" target="_blank">Login Form</a></li>';
echo '<li><a href="http://localhost/ITE311-TERRADO/dashboard" target="_blank">Dashboard (requires login)</a></li>';
echo '<li><a href="http://localhost/ITE311-TERRADO/logout" target="_blank">Logout</a></li>';
echo '</ul>';
?>