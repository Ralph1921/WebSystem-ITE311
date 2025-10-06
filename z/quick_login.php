<?php
// Quick login that properly sets CodeIgniter session
require_once 'vendor/autoload.php';

// Initialize CodeIgniter manually
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');
$paths = new \Config\Paths();
$app = new \CodeIgniter\CodeIgniter($paths);
$app->initialize();

// Get session service
$session = \Config\Services::session();

// Set session data like the Auth controller
$sessionData = [
    'user_id' => 1,
    'name' => 'Terrado User', 
    'email' => 'terrado@gmail.com',
    'role' => 'admin',
    'logged_in' => true
];

$session->set($sessionData);
$session->setFlashdata('success', 'Welcome back, Terrado User!');

// Redirect to dashboard
header('Location: ' . base_url('/dashboard'));
exit;
?>
