<?php
/**
 * This file is used to redirect requests to the public directory
 * where the actual CodeIgniter 4 application resides.
 */

// Check if we're already in the public directory to avoid infinite loops
if (basename(__DIR__) !== 'public') {
    // Redirect to the public directory
    header('Location: public/');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Redirecting...</title>
</head>
<body>
    <p>Redirecting to application...</p>
    <script>
        window.location.href = 'public/';
    </script>
</body>
</html>