<?php
// Complete login and dashboard flow test

echo "<h1>🔧 Complete Login Flow Test</h1>";

// Function to make POST request to login
function testLogin() {
    $postData = [
        'email' => 'terrado@gmail.com',
        'password' => 'siopao123',
        'csrf_test_name' => 'test' // CodeIgniter CSRF token placeholder
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $httpCode,
        'final_url' => $finalUrl
    ];
}

// Function to test dashboard access
function testDashboard() {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/dashboard');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookies.txt');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    
    curl_close($ch);
    
    return [
        'response' => $response,
        'http_code' => $httpCode,
        'final_url' => $finalUrl
    ];
}

echo "<h2>📋 Test Results</h2>";

// Test 1: Check login page accessibility
echo "<h3>Test 1: Login Page Accessibility</h3>";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOBODY, true);
$result = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 200) {
    echo "✅ Login page is accessible (HTTP $httpCode)<br>";
} else {
    echo "❌ Login page not accessible (HTTP $httpCode)<br>";
}

// Test 2: Dashboard page accessibility (should redirect to login)
echo "<h3>Test 2: Dashboard Access (Without Login)</h3>";
$dashResult = testDashboard();
echo "HTTP Code: " . $dashResult['http_code'] . "<br>";
echo "Final URL: " . $dashResult['final_url'] . "<br>";

if (strpos($dashResult['final_url'], '/login') !== false) {
    echo "✅ Properly redirected to login when not authenticated<br>";
} else {
    echo "❌ Did not redirect to login<br>";
}

// Test 3: Login attempt
echo "<h3>Test 3: Login Attempt</h3>";
$loginResult = testLogin();
echo "Login HTTP Code: " . $loginResult['http_code'] . "<br>";
echo "Login Final URL: " . $loginResult['final_url'] . "<br>";

if (strpos($loginResult['final_url'], '/dashboard') !== false) {
    echo "✅ Successfully redirected to dashboard after login<br>";
} elseif ($loginResult['http_code'] == 200) {
    echo "⚠️ Login page returned but no redirect occurred<br>";
} else {
    echo "❌ Login failed (HTTP " . $loginResult['http_code'] . ")<br>";
}

// Test 4: Dashboard access after login
echo "<h3>Test 4: Dashboard Access After Login</h3>";
$dashAfterLogin = testDashboard();
echo "Dashboard HTTP Code: " . $dashAfterLogin['http_code'] . "<br>";
echo "Dashboard Final URL: " . $dashAfterLogin['final_url'] . "<br>";

if ($dashAfterLogin['http_code'] == 200 && strpos($dashAfterLogin['final_url'], '/dashboard') !== false) {
    echo "✅ Dashboard accessible after login<br>";
    
    // Check if welcome message is present
    if (strpos($dashAfterLogin['response'], 'terrado@gmail.com') !== false) {
        echo "✅ Welcome message with email found<br>";
    } else {
        echo "❌ Welcome message not found<br>";
    }
} else {
    echo "❌ Dashboard not accessible after login<br>";
}

echo "<h2>🔗 Manual Test Links</h2>";
echo "<ul>";
echo "<li><a href='http://localhost/ITE311-TERRADO/login' target='_blank'>CodeIgniter Login</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/dashboard' target='_blank'>CodeIgniter Dashboard</a></li>";
echo "<li><a href='simple_login_test.php' target='_blank'>Simple Login Test</a></li>";
echo "<li><a href='simple_dashboard_test.php' target='_blank'>Simple Dashboard Test</a></li>";
echo "</ul>";

// Clean up cookies file
if (file_exists('cookies.txt')) {
    unlink('cookies.txt');
}
?>