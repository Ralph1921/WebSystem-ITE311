<?php
// Diagnostic: verify login for a specific email/password directly via mysqli (port 3307)
// Visit: /debug_login.php
// Security: remove this file after use.

declare(strict_types=1);
header('Content-Type: text/plain');

$host = 'localhost';
$port = 3307; // your MySQL port
$user = 'root';
$pass = '';
$db   = 'lms_terrado';

$email = 'terrado@gmail.com';
$plain = 'siopao123';

function out($m){ echo $m, "\n"; }

try {
    $mysqli = @new mysqli($host, $user, $pass, $db, $port);
    if ($mysqli->connect_error) {
        out('❌ Connect error: ' . $mysqli->connect_error);
        exit(1);
    }
    out('✅ Connected to MySQL ' . $host . ':' . $port . ' DB=' . $db);

    $stmt = $mysqli->prepare('SELECT id, email, password, role, created_at FROM users WHERE email=? LIMIT 1');
    if (!$stmt) { out('❌ Prepare failed: ' . $mysqli->error); exit(1); }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res->num_rows === 0) {
        out('❌ No user found with that email: ' . $email);
        exit(2);
    }
    $row = $res->fetch_assoc();
    out('ℹ️  Found user id=' . $row['id'] . ' email=' . $row['email'] . ' role=' . $row['role']);

    $hash = (string)$row['password'];
    $ok = password_verify($plain, $hash);
    out('🔐 password_verify result: ' . ($ok ? 'MATCH' : 'NO MATCH'));

    if ($ok) {
        out("\nIf the /login still hangs, the issue is not credentials — likely a routing or session problem.");
    } else {
        out("\nThe password is incorrect. Recreate user or update password hash.");
    }

    $stmt->close();
    $mysqli->close();
} catch (Throwable $e) {
    out('❌ Exception: ' . $e->getMessage());
    exit(1);
}
