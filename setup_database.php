<?php
// Simple database setup for LMS
$host = 'localhost';
$port = '3307';
$username = 'root';
$password = '';
$database = 'lms_terrado';

try {
    // Connect to MySQL server
    $pdo = new PDO("mysql:host=$host;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database`");
    echo "✓ Database '$database' created<br>";
    
    // Connect to the specific database
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$database", $username, $password);
    
    // Create users table
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `role` varchar(50) NOT NULL DEFAULT 'student',
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )");
    
    // Create courses table  
    $pdo->exec("
    CREATE TABLE IF NOT EXISTS `courses` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `title` varchar(255) NOT NULL,
        `description` text,
        `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    )");
    
    // Clear and insert sample data
    $pdo->exec("DELETE FROM users");
    $pdo->exec("DELETE FROM courses");
    
    // Insert 7 users to match your first screenshot
    $pdo->exec("
    INSERT INTO `users` (`name`, `email`, `role`) VALUES
    ('Admin User', 'admin@test.com', 'admin'),
    ('Teacher One', 'teacher1@test.com', 'teacher'),
    ('Teacher Two', 'teacher2@test.com', 'teacher'),
    ('Student One', 'student1@test.com', 'student'),
    ('Student Two', 'student2@test.com', 'student'),
    ('Student Three', 'student3@test.com', 'student'),
    ('Student Four', 'student4@test.com', 'student')");
    
    // Insert 4 courses to match your first screenshot
    $pdo->exec("
    INSERT INTO `courses` (`title`, `description`) VALUES
    ('Web Development', 'Learn HTML, CSS, and JavaScript'),
    ('Database Systems', 'Introduction to MySQL and databases'), 
    ('Programming Fundamentals', 'Learn programming basics'),
    ('Software Engineering', 'Software development principles')");
    
    // Show results
    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $courseCount = $pdo->query("SELECT COUNT(*) FROM courses")->fetchColumn();
    $teacherCount = $pdo->query("SELECT COUNT(*) FROM users WHERE role = 'teacher'")->fetchColumn();
    
    echo "✓ Tables created and data inserted<br><br>";
    echo "<strong>Results:</strong><br>";
    echo "Total Users: $userCount<br>";
    echo "Total Courses: $courseCount<br>";
    echo "Active Teachers: $teacherCount<br><br>";
    echo "Now refresh your admin dashboard - the numbers should be back!";
    
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>