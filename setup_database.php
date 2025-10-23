<?php
$host = 'localhost';
$port = 3306;
$username = 'root';
$password = '';
$database = 'lms_terrado';

try {
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
    $pdo->exec("USE `$database`");

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `users` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(100) NOT NULL,
            `email` VARCHAR(100) UNIQUE NOT NULL,
            `password` VARCHAR(255) NOT NULL,
            `role` VARCHAR(20) DEFAULT 'user',
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )
    ");

    $hashedPassword = password_hash('siopao123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO `users` (`name`, `email`, `password`, `role`) VALUES (?, ?, ?, ?)");
    $stmt->execute(['Admin User', 'admin@test.com', $hashedPassword, 'admin']);

} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
