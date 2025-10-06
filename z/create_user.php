<?php
// One-time script to create a user in lms_terrado.users
// IMPORTANT: Delete this file after successful run for security.

declare(strict_types=1);

$host = 'localhost';
$port = 3307; // MySQL port per your setup
$user = 'root';
$pass = '';
$dbName = 'lms_terrado';

// Provided credentials
$name = 'Terrado';
$email = 'terrado@gmail.com';
$passwordPlain = 'siopao123';
$role = 'user';

header('Content-Type: text/plain');

function exitWith(string $msg, int $code = 200): void {
    http_response_code($code);
    echo $msg, "\n";
    exit;
}

try {
    // 1) Connect to MySQL server (without selecting DB) so we can create DB if needed
    $mysqli = @new mysqli($host, $user, $pass, '', $port);
    if ($mysqli->connect_error) {
        exitWith('❌ MySQL connection error: ' . $mysqli->connect_error, 500);
    }

    echo "✅ Connected to MySQL on {$host}:{$port}\n";

    // 2) Ensure database exists
    if (!$mysqli->query("CREATE DATABASE IF NOT EXISTS `{$dbName}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci")) {
        exitWith('❌ Failed to create database: ' . $mysqli->error, 500);
    }
    echo "✅ Database ensured: {$dbName}\n";

    if (!$mysqli->select_db($dbName)) {
        exitWith('❌ Failed to select database: ' . $mysqli->error, 500);
    }

    // 3) Ensure users table exists (schema compatible with app)
    $createTableSQL = <<<SQL
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

    if (!$mysqli->query($createTableSQL)) {
        exitWith('❌ Failed to create/ensure users table: ' . $mysqli->error, 500);
    }
    echo "✅ Table ensured: users\n";

    // 4) Check if email already exists
    $stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
    if (!$stmt) {
        exitWith('❌ Prepare failed: ' . $mysqli->error, 500);
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->close();
        exitWith("ℹ️ Email already exists: {$email}\nYou can log in now at /login", 200);
    }
    $stmt->close();

    // 5) Hash password and insert
    $hash = password_hash($passwordPlain, PASSWORD_DEFAULT);
    if ($hash === false) {
        exitWith('❌ Failed to hash password', 500);
    }

    $now = date('Y-m-d H:i:s');
    $insert = $mysqli->prepare('INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?)');
    if (!$insert) {
        exitWith('❌ Prepare insert failed: ' . $mysqli->error, 500);
    }
    $insert->bind_param('ssssss', $name, $email, $hash, $role, $now, $now);
    if (!$insert->execute()) {
        $insert->close();
        exitWith('❌ Insert failed: ' . $mysqli->error, 500);
    }
    $insert->close();

    echo "✅ User created successfully!\n";
    echo "\nLogin with:\n";
    echo " - Email: {$email}\n";
    echo " - Password: {$passwordPlain}\n";
    echo "\nNext steps:\n - Visit /login and sign in.\n - DELETE this file for security: create_user.php\n";

    $mysqli->close();
    // Optional: attempt to self-delete. On Windows this may fail if in use.
    // @unlink(__FILE__);

} catch (Throwable $e) {
    exitWith('❌ Exception: ' . $e->getMessage(), 500);
}
