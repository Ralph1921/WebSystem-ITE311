<?php
// Simple script to create the database
$host = 'localhost';
$username = 'root';
$password = ''; // Change this if your MySQL has a password

echo "Attempting to connect to MySQL...\n";

try {
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Connected to MySQL successfully!\n";
    
    // Create database
    $sql = "CREATE DATABASE IF NOT EXISTS lms_terrado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
    $pdo->exec($sql);
    
    echo "Database 'lms_terrado' created successfully!\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
