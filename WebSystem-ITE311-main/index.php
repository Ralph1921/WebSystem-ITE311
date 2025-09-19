<?php
/**
 * Redirect to public folder
 * This file redirects requests to the public folder where the actual CodeIgniter 4 entry point is located.
 */

// Redirect to public folder
header('Location: public/');
exit();
