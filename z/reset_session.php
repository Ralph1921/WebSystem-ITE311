<?php
// Reset session script
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Reset</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 100px; }
        .success { background: #d4edda; padding: 20px; margin: 20px auto; border-radius: 5px; max-width: 600px; }
        .btn { display: inline-block; padding: 10px 20px; margin: 10px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <h1>✅ Session Cleared Successfully!</h1>
    
    <div class="success">
        <h2>Your session has been reset</h2>
        <p>This should fix the email display issue. Now when you login, you should see <strong>terrado@gmail.com</strong> instead of benz@gmail.com.</p>
    </div>
    
    <h3>Next Steps:</h3>
    <p>1. Clear your browser cache (Ctrl+F5)</p>
    <p>2. Login again with your credentials</p>
    
    <div>
        <strong>Your Login Credentials:</strong><br>
        Email: terrado@gmail.com<br>
        Password: siopao123
    </div>
    
    <br>
    <a href="http://localhost/ITE311-TERRADO/login" class="btn">Go to Login Page</a>
    <a href="MASTER_TEST.html" class="btn">Go to Test Page</a>
</body>
</html>