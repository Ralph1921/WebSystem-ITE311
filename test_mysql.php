<?php
// Test MySQL connection
$host = '127.0.0.1';
$user = 'root';
$password = '';
$port = 3306;

echo "<h2>Testing MySQL Connection</h2>";

try {
    $conn = new mysqli($host, $user, $password, '', $port);
    
    if ($conn->connect_error) {
        die("<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>");
    }
    
    echo "<p style='color: green;'>Connected successfully as root!</p>";
    
    // Show current user
    $result = $conn->query("SELECT USER(), CURRENT_USER()");
    if ($result) {
        $row = $result->fetch_row();
        echo "<p>Current User: " . $row[0] . "</p>";
        echo "<p>Effective User: " . $row[1] . "</p>";
    }
    
    // Show databases
    echo "<h3>Available Databases:</h3>";
    $result = $conn->query("SHOW DATABASES");
    if ($result) {
        while ($row = $result->fetch_row()) {
            echo "<p>- " . $row[0] . "</p>";
        }
    }
    
    // Check if lms_terrado user exists
    echo "<h3>Users in MySQL:</h3>";
    $result = $conn->query("SELECT User, Host FROM mysql.user");
    if ($result) {
        while ($row = $result->fetch_row()) {
            echo "<p>User: " . $row[0] . "@" . $row[1] . "</p>";
        }
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}
?>