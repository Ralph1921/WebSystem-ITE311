<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    /**
     * Enable/Disable migrations.
     *
     * @var bool
     */
    public $enabled = true;

    /**
     * Type of migrations: 'timestamp' or 'sequential'
     *
     * @var string
     */
    public $type = 'timestamp';

    /**
     * Migrations table name.
     *
     * @var string
     */
    public $table = 'migrations';

    /**
     * Directory where migrations are located.
     *
     * @var string
     */
    public $directory = APPPATH . 'Database/Migrations/';

    /**
     * Namespace for migrations.
     *
     * @var string
     */
    public $namespace = 'App\\Database\\Migrations';
}
