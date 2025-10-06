<?php
/**
 * Front controller shim to include public/index.php without redirecting.
 * This keeps clean URLs like /ITE311-TERRADO/ while serving from /public.
 */
require __DIR__ . '/public/index.php';
