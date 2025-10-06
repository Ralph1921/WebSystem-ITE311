<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    
    public $defaultGroup = 'default';

    
    public $filesPath = APPPATH . 'Database/';

    
    public $default = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',       
        'password' => '',           
        'database' => 'lms_terrado',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => true,
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];

   
    public $tests = [
        'DSN'      => '',
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'lms_terrado',
        'DBDriver' => 'MySQLi',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress'  => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
}
