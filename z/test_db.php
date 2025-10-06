<?php
// Test database connection
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'lms_terrado';

try {
    $port = 3307;
    $conn = new mysqli($host, $username, $password, $database, $port);
    
    if ($conn->connect_error) {
        echo "Connection failed: " . $conn->connect_error;
    } else {
        echo "Database connection successful!";
        $conn->close();
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
