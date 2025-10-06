<?php
// Simple test to check login functionality
session_start();

if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Check the hardcoded credentials from Auth controller
    if ($email === 'terrado@gmail.com' && $password === 'siopao123') {
        $_SESSION['user_id'] = 1;
        $_SESSION['name'] = 'Terrado User';
        $_SESSION['email'] = 'terrado@gmail.com';
        $_SESSION['role'] = 'admin';
        $_SESSION['logged_in'] = true;
        
        echo "<h2>✅ Login Successful!</h2>";
        echo "<p>Session data set:</p>";
        echo "<pre>" . print_r($_SESSION, true) . "</pre>";
        echo "<p><a href='http://localhost/ITE311-TERRADO/dashboard'>Click here to go to Dashboard</a></p>";
        echo "<p><a href='simple_dashboard_test.php'>Or test Simple Dashboard</a></p>";
    } else {
        echo "<h2>❌ Login Failed</h2>";
        echo "<p>Invalid credentials. Expected: terrado@gmail.com / siopao123</p>";
    }
} else {
    echo "<h2>Login Test</h2>";
    echo "<form method='POST'>";
    echo "Email: <input type='email' name='email' value='terrado@gmail.com'><br><br>";
    echo "Password: <input type='password' name='password' value='siopao123'><br><br>";
    echo "<input type='submit' value='Test Login'>";
    echo "</form>";
}

echo "<h3>Current Session:</h3>";
echo "<pre>" . print_r($_SESSION, true) . "</pre>";
?>