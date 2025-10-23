<?php
// Test the complete login process
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🧪 Testing Complete Login Flow</h1>\n";

echo "<h2>Step 1: Testing Login Form</h2>\n";

// Test GET request to login
$login_get = file_get_contents('http://localhost/ITE311-TERRADO/login');
if (strpos($login_get, 'login') !== false) {
    echo "✅ Login form loads correctly<br>\n";
} else {
    echo "❌ Login form has issues<br>\n";
}

echo "<h2>Step 2: Testing Login POST</h2>\n";

// Simulate login POST request
$postData = [
    'email' => 'terrado@gmail.com',
    'password' => 'siopao123'
];

$options = [
    'http' => [
        'header' => "Content-type: application/x-www-form-urlencoded\r\n",
        'method' => 'POST',
        'content' => http_build_query($postData),
        'follow_location' => 0  // Don't follow redirects automatically
    ]
];

$context = stream_context_create($options);
$result = @file_get_contents('http://localhost/ITE311-TERRADO/login', false, $context);

// Check response headers
$headers = $http_response_header ?? [];
$redirect_location = '';
foreach ($headers as $header) {
    if (strpos($header, 'Location:') === 0) {
        $redirect_location = trim(substr($header, 9));
        break;
    }
}

echo "<h3>Login Response:</h3>\n";
if ($redirect_location) {
    echo "✅ Login redirects to: <strong>$redirect_location</strong><br>\n";
    
    if (strpos($redirect_location, 'dashboard') !== false) {
        echo "✅ Redirects to dashboard as expected<br>\n";
    } else {
        echo "❌ Does not redirect to dashboard<br>\n";
    }
} else {
    echo "❌ No redirect found - login might have failed<br>\n";
    if (strpos($result, 'error') !== false || strpos($result, 'Invalid') !== false) {
        echo "❌ Login validation error detected<br>\n";
    }
}

echo "<h2>🚀 Quick Fix - Direct Dashboard Access</h2>\n";
echo "<p>While we debug the login, you can see your dashboard directly:</p>\n";
echo "<p><a href='/ITE311-TERRADO/dashboard-show' style='background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>View Your Dashboard</a></p>\n";

echo "<h2>🔧 Alternative Login Methods</h2>\n";
echo "<ol>\n";
echo "<li><strong>Clear browser cache completely</strong> (Ctrl+Shift+Delete)</li>\n";
echo "<li><strong>Try incognito/private window</strong></li>\n";
echo "<li><strong>Try this direct login:</strong> <a href='/ITE311-TERRADO/dashboard-show'>dashboard-show</a></li>\n";
echo "</ol>\n";

if ($result && strlen($result) > 100) {
    echo "<h3>📝 Debug Info:</h3>\n";
    echo "<details><summary>Click to see login response</summary>\n";
    echo "<pre>" . htmlspecialchars(substr($result, 0, 1000)) . "...</pre>\n";
    echo "</details>\n";
}
?>