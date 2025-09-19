<?php
echo "<h2>Testing Connection with localhost vs 127.0.0.1</h2>";

$user = 'root';
$passwords = ['', 'root', 'admin', 'password'];
$hosts = ['localhost', '127.0.0.1', '::1'];
$port = 3306;

foreach ($hosts as $host) {
    echo "<h3>Testing host: $host</h3>";
    
    foreach ($passwords as $password) {
        echo "<p>Testing password: '" . ($password === '' ? '(empty)' : $password) . "' on $host</p>";
        
        try {
            $conn = new mysqli($host, $user, $password, '', $port);
            
            if (!$conn->connect_error) {
                echo "<p style='color: green; font-weight: bold;'>SUCCESS! Working combination:</p>";
                echo "<ul>";
                echo "<li>Host: $host</li>";
                echo "<li>User: $user</li>";
                echo "<li>Password: '" . ($password === '' ? '(empty)' : $password) . "'</li>";
                echo "</ul>";
                
                // Update phpMyAdmin config
                $configFile = 'C:\\xampp\\phpMyAdmin\\config.inc.php';
                $config = file_get_contents($configFile);
                $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['host'\] = '.*';/", "\$cfg['Servers'][\$i]['host'] = '$host';", $config);
                $config = preg_replace("/\\\$cfg\['Servers'\]\[\\\$i\]\['password'\] = '.*';/", "\$cfg['Servers'][\$i]['password'] = '$password';", $config);
                file_put_contents($configFile, $config);
                
                echo "<p style='color: blue;'>phpMyAdmin configuration updated!</p>";
                echo "<p><a href='http://127.0.0.1/phpmyadmin/' target='_blank'>Try phpMyAdmin now</a></p>";
                
                $conn->close();
                exit; // Stop testing once we find a working combination
            } else {
                echo "<p style='color: red;'>Failed: " . $conn->connect_error . "</p>";
            }
        } catch (Exception $e) {
            echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
        }
    }
    echo "<hr>";
}

echo "<h3>No working combination found</h3>";
echo "<p>You'll need to run the password reset script as administrator:</p>";
echo "<p><strong>Right-click on 'reset_mysql_admin.bat' and select 'Run as administrator'</strong></p>";
?>