<?php
echo "<h2>Testing Common XAMPP Passwords</h2>";

$host = '127.0.0.1';
$user = 'root';
$port = 3306;

// Common passwords to try
$passwords = ['', 'root', 'admin', 'password', 'xampp', 'mysql'];

foreach ($passwords as $password) {
    echo "<p>Testing password: '" . ($password === '' ? '(empty)' : $password) . "'</p>";
    
    try {
        $conn = new mysqli($host, $user, $password, '', $port);
        
        if (!$conn->connect_error) {
            echo "<p style='color: green; font-weight: bold;'>SUCCESS! Working password: '" . ($password === '' ? '(empty)' : $password) . "'</p>";
            
            // Show some basic info
            $result = $conn->query("SELECT VERSION() as version");
            if ($result) {
                $row = $result->fetch_assoc();
                echo "<p>MariaDB Version: " . $row['version'] . "</p>";
            }
            
            $conn->close();
            
            // Update phpMyAdmin config automatically
            $configFile = 'C:\\xampp\\phpMyAdmin\\config.inc.php';
            $config = file_get_contents($configFile);
            $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['password'\] = '.*';/", "\$cfg['Servers'][\$i]['password'] = '$password';", $config);
            file_put_contents($configFile, $config);
            
            echo "<p style='color: blue;'>phpMyAdmin configuration updated automatically!</p>";
            echo "<p><a href='http://127.0.0.1/phpmyadmin/' target='_blank'>Click here to access phpMyAdmin</a></p>";
            break;
        } else {
            echo "<p style='color: red;'>Failed: " . $conn->connect_error . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
?>