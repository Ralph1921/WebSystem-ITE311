<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Migrations extends BaseConfig
{
    /**
     * --------------------------------------------------------------------------
     * Migrations Enabled
     * --------------------------------------------------------------------------
     * If true, migrations are enabled.
     */
    public $enabled = TRUE;

    /**
     * --------------------------------------------------------------------------
     * Migrations Type
     * --------------------------------------------------------------------------
     * 'sequential' or 'timestamp'.
     * 
     * - 'sequential' means migration filenames start with a number (001_…)
     * - 'timestamp' means filenames start with a timestamp
     */
    public $type = 'sequential';

    /**
     * --------------------------------------------------------------------------
     * Migrations Table
     * --------------------------------------------------------------------------
     * Name of the table that keeps track of which migrations have run.
     */
    public $table = 'migrations';

    /**
     * --------------------------------------------------------------------------
     * Auto Migrate To Latest
     * --------------------------------------------------------------------------
     * If true, running the app automatically migrates to the latest version.
     * Usually false in production.
     */
    public $autoMigrate = false;

    /**
     * --------------------------------------------------------------------------
     * Migrations Namespace
     * --------------------------------------------------------------------------
     * Default namespace for migrations.
     */
    public $namespace = 'App\Database\Migrations';

    /**
     * --------------------------------------------------------------------------
     * Default Directory
     * --------------------------------------------------------------------------
     * The folder that holds all migration files.
     */
    public $directory = APPPATH . 'Database/Migrations';
}
