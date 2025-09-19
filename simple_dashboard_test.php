<?php
// Simple dashboard test page
session_start();

echo "<h1>Simple Dashboard Test</h1>";

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    echo "<div style='background: #d4edda; padding: 20px; border: 1px solid #c3e6cb; margin: 10px 0;'>";
    echo "<h2>✅ Welcome back!</h2>";
    echo "<p><strong>Welcome, " . htmlspecialchars($_SESSION['email']) . "!</strong></p>";
    echo "<p>Name: " . htmlspecialchars($_SESSION['name']) . "</p>";
    echo "<p>Role: " . htmlspecialchars($_SESSION['role']) . "</p>";
    echo "<p>User ID: " . htmlspecialchars($_SESSION['user_id']) . "</p>";
    echo "</div>";
    
    echo "<p><a href='http://localhost/ITE311-TERRADO/logout' style='color: red;'>Logout</a></p>";
} else {
    echo "<div style='background: #f8d7da; padding: 20px; border: 1px solid #f5c6cb; margin: 10px 0;'>";
    echo "<h2>❌ Not logged in</h2>";
    echo "<p>Session data not found or user not logged in.</p>";
    echo "</div>";
    
    echo "<p><a href='simple_login_test.php'>Go to Login Test</a></p>";
    echo "<p><a href='http://localhost/ITE311-TERRADO/login'>Go to CodeIgniter Login</a></p>";
}

echo "<h3>Debug - All Session Data:</h3>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";

echo "<h3>Navigation Links:</h3>";
echo "<ul>";
echo "<li><a href='simple_login_test.php'>Simple Login Test</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/login'>CodeIgniter Login</a></li>";
echo "<li><a href='http://localhost/ITE311-TERRADO/dashboard'>CodeIgniter Dashboard</a></li>";
echo "<li><a href='debug_login_complete.php'>Complete Debug Test</a></li>";
echo "</ul>";
?>