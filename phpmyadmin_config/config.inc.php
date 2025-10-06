<?php
/* phpMyAdmin configuration for XAMPP with MySQL on port 3307
 * Provides two server entries so you can choose the one matching your MySQL user host.
 */

$cfg['blowfish_secret'] = 'zE6bYp2QnR9uJ4xV8tM1cA7sG3wH5kP0fD2L6mN8rB4vT1yC9qU3eS7aZ1'; // 32+ chars

/* Server 1: localhost (use when user is 'root'@'localhost') */
$i = 0; $i++;
$cfg['Servers'][$i]['host'] = 'localhost';
$cfg['Servers'][$i]['port'] = '3307';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['AllowNoPassword'] = true; // XAMPP default root without password
unset($cfg['Servers'][$i]['controluser']);
unset($cfg['Servers'][$i]['controlpass']);
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['ssl'] = false;

/* Server 2: 127.0.0.1 (use when user is 'root'@'127.0.0.1') */
$i++; // server 2
$cfg['Servers'][$i]['host'] = '127.0.0.1';
$cfg['Servers'][$i]['port'] = '3307';
$cfg['Servers'][$i]['auth_type'] = 'cookie';
$cfg['Servers'][$i]['AllowNoPassword'] = true;
unset($cfg['Servers'][$i]['controluser']);
unset($cfg['Servers'][$i]['controlpass']);
$cfg['Servers'][$i]['compress'] = false;
$cfg['Servers'][$i]['ssl'] = false;

/* UI */
$cfg['ThemeDefault'] = 'pmahomme';
$cfg['UploadDir'] = '';
$cfg['SaveDir'] = '';
