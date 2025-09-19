<?php
// Simple CodeIgniter login test without CSRF
if ($_POST) {
    // Make a direct POST request to the CodeIgniter login endpoint
    $postData = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost/ITE311-TERRADO/login');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_COOKIEJAR, 'temp_cookies.txt');
    curl_setopt($ch, CURLOPT_COOKIEFILE, 'temp_cookies.txt');
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $finalUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    curl_close($ch);
    
    echo "<h2>🔍 Login Test Result:</h2>";
    echo "<p><strong>HTTP Code:</strong> $httpCode</p>";
    echo "<p><strong>Final URL:</strong> $finalUrl</p>";
    
    if (strpos($finalUrl, '/dashboard') !== false) {
        echo "<div style='background: #d4edda; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>✅ SUCCESS!</h3>";
        echo "<p>Login worked! You should be redirected to dashboard.</p>";
        echo "<p><a href='$finalUrl'>Click here to go to your dashboard</a></p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; padding: 20px; border-radius: 5px; margin: 20px 0;'>";
        echo "<h3>❌ Login Failed</h3>";
        echo "<p>The login did not redirect to dashboard. This might be a CSRF or validation issue.</p>";
        echo "</div>";
        
        // Show part of the response for debugging
        echo "<h3>Response Preview:</h3>";
        echo "<pre>" . htmlspecialchars(substr($response, 0, 1000)) . "...</pre>";
    }
    
    // Clean up
    if (file_exists('temp_cookies.txt')) {
        unlink('temp_cookies.txt');
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Simple CI Login Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .credentials { background: #f8f9fa; padding: 15px; border-radius: 4px; margin: 20px 0; }
    </style>
</head>
<body>
    <h1>🧪 Simple CodeIgniter Login Test</h1>
    
    <div class="credentials">
        <strong>Test Credentials:</strong><br>
        Email: terrado@gmail.com<br>
        Password: siopao123
    </div>
    
    <form method="POST">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="terrado@gmail.com" required>
        </div>
        
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" value="siopao123" required>
        </div>
        
        <button type="submit">Test Login</button>
    </form>
    
    <h3>🔗 Other Tests:</h3>
    <ul>
        <li><a href="check_login_status.php">Check Login Status</a></li>
        <li><a href="simple_login_test.php">Simple PHP Login</a></li>
        <li><a href="http://localhost/ITE311-TERRADO/login">Original CI Login</a></li>
    </ul>
</body>
</html>