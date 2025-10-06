<?php
// Debug script to test the complete login flow
session_start();

echo "<h1>Login Flow Debug Test</h1>";

// Test 1: Check if we can simulate a login
echo "<h2>Test 1: Simulate Login</h2>";
$_SESSION['user_id'] = 1;
$_SESSION['name'] = 'Terrado User';
$_SESSION['email'] = 'terrado@gmail.com';
$_SESSION['role'] = 'admin';
$_SESSION['logged_in'] = true;

echo "Session data set:<br>";
print_r($_SESSION);

// Test 2: Redirect to dashboard
echo "<h2>Test 2: Dashboard Access</h2>";
echo "<p>Click this link to test dashboard access: <a href='http://localhost/ITE311-TERRADO/dashboard'>Go to Dashboard</a></p>";

// Test 3: Check dashboard route directly
echo "<h2>Test 3: Direct Dashboard Test</h2>";
echo "<form method='POST' action='http://localhost/ITE311-TERRADO/login'>";
echo "<input type='hidden' name='email' value='terrado@gmail.com'>";
echo "<input type='hidden' name='password' value='siopao123'>";
echo "<input type='submit' value='Auto Login and Redirect'>";
echo "</form>";

echo "<h2>Current Session Status:</h2>";
echo "Logged in: " . (isset($_SESSION['logged_in']) ? 'Yes' : 'No') . "<br>";
echo "Email: " . (isset($_SESSION['email']) ? $_SESSION['email'] : 'Not set') . "<br>";
?>