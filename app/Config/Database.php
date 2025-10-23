<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public string $filesPath = APPPATH . 'Database' . DIRECTORY_SEPARATOR;
    public string $defaultGroup = 'default';

    public array $default = [
<<<<<<< HEAD
        'DSN'       => '',
        'hostname'  => 'localhost',
        'username'  => 'root',
        'password'  => '',
        'database'  => 'lms_terrado',
        'DBDriver'  => 'MySQLi',
        'DBPrefix'  => '',
        'pConnect'  => false,
        'DBDebug'   => false,
        'charset'   => 'utf8mb4',
        'DBCollat'  => 'utf8mb4_unicode_ci',
        'swapPre'   => '',
        'encrypt'   => false,
        'compress'  => false,
        'strictOn'  => false,
        'failover'  => [],
        'port'      => 3306,
        'numberNative' => false,
=======
        'DSN'          => '',
        'hostname'     => 'localhost',
        'username'     => 'root',
        'password'     => '', // No password for easy development
        'database'     => 'lms_terrado',
        'DBDriver'     => 'MySQLi',
        'DBPrefix'     => '',
        'pConnect'     => false,
        'DBDebug'      => false, // Set to false to handle errors gracefully
        'charset'      => 'utf8mb4',
        'DBCollat'     => 'utf8mb4_unicode_ci',
        'swapPre'      => '',
        'encrypt'      => false,
        'compress'     => false,
        'strictOn'     => false,
        'failover'     => [],
        'port'         => 3307, // Your MySQL port
>>>>>>> c2bc064 (Update .gitignore to exclude my-student-dashboard)
    ];

    public array $tests = [
        'DSN'         => '',
        'hostname'    => '127.0.0.1',
        'username'    => '',
        'password'    => '',
        'database'    => ':memory:',
        'DBDriver'    => 'SQLite3',
        'DBPrefix'    => 'db_',
        'pConnect'    => false,
        'DBDebug'     => true,
        'charset'     => 'utf8',
        'DBCollat'    => 'utf8_general_ci',
        'swapPre'     => '',
        'encrypt'     => false,
        'compress'    => false,
        'strictOn'    => false,
        'failover'    => [],
        'port'        => 3306,
        'foreignKeys' => true,
        'busyTimeout' => 1000,
    ];

    public function __construct()
    {
        parent::__construct();

        if (ENVIRONMENT === 'testing') {
            $this->defaultGroup = 'tests';
        }

      
        $this->default['hostname'] = env('database.default.hostname', $this->default['hostname']);
        $this->default['username'] = env('database.default.username', $this->default['username']);
        $this->default['password'] = env('database.default.password', $this->default['password']);
        $this->default['database'] = env('database.default.database', $this->default['database']);
        $this->default['DBDriver'] = env('database.default.DBDriver', $this->default['DBDriver']);
        $this->default['port']     = (int) env('database.default.port', (string) $this->default['port']);

        $this->default['DBDebug']  = (ENVIRONMENT !== 'production');
    }
}
