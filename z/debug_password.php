<?php
if ($_POST) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    echo "<h2>🔍 Password Debug Results:</h2>";
    echo "<p><strong>Email received:</strong> '$email'</p>";
    echo "<p><strong>Email length:</strong> " . strlen($email) . "</p>";
    echo "<p><strong>Email trimmed:</strong> '" . trim($email) . "'</p>";
    echo "<p><strong>Email match:</strong> " . (trim($email) === 'terrado@gmail.com' ? '✅ YES' : '❌ NO') . "</p>";
    
    echo "<hr>";
    
    echo "<p><strong>Password received:</strong> '$password'</p>";
    echo "<p><strong>Password length:</strong> " . strlen($password) . "</p>";
    echo "<p><strong>Password trimmed:</strong> '" . trim($password) . "'</p>";
    echo "<p><strong>Expected password:</strong> 'siopao123'</p>";
    echo "<p><strong>Expected length:</strong> " . strlen('siopao123') . "</p>";
    echo "<p><strong>Password match:</strong> " . (trim($password) === 'siopao123' ? '✅ YES' : '❌ NO') . "</p>";
    
    echo "<hr>";
    
    // Character by character comparison
    echo "<h3>Character-by-Character Analysis:</h3>";
    $expected = 'siopao123';
    $received = trim($password);
    
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Position</th><th>Expected</th><th>Received</th><th>ASCII Expected</th><th>ASCII Received</th><th>Match</th></tr>";
    
    $maxLen = max(strlen($expected), strlen($received));
    for ($i = 0; $i < $maxLen; $i++) {
        $expChar = $i < strlen($expected) ? $expected[$i] : '';
        $recChar = $i < strlen($received) ? $received[$i] : '';
        $expAscii = $expChar !== '' ? ord($expChar) : '';
        $recAscii = $recChar !== '' ? ord($recChar) : '';
        $match = $expChar === $recChar ? '✅' : '❌';
        
        echo "<tr>";
        echo "<td>$i</td>";
        echo "<td>$expChar</td>";
        echo "<td>$recChar</td>";
        echo "<td>$expAscii</td>";
        echo "<td>$recAscii</td>";
        echo "<td>$match</td>";
        echo "</tr>";
    }
    echo "</table>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Debug Test</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        table { width: 100%; margin: 10px 0; }
        th, td { padding: 8px; text-align: center; }
        .form-group { margin: 15px 0; }
        input { width: 100%; padding: 8px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>🐛 Password Debug Test</h1>
    
    <form method="POST">
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="terrado@gmail.com">
        </div>
        
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" value="siopao123">
        </div>
        
        <button type="submit">Debug Password</button>
    </form>
    
    <h3>🔗 Other Tests:</h3>
    <ul>
        <li><a href="http://localhost/ITE311-TERRADO/login">Try CodeIgniter Login</a></li>
        <li><a href="check_login_status.php">Check Login Status</a></li>
        <li><a href="MASTER_TEST.html">Master Test Page</a></li>
    </ul>
</body>
</html>