<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class DbCheck extends BaseCommand
{
    protected $group       = 'Custom';
    protected $name        = 'db:check';
    protected $description = 'Checks database connection';

    public function run(array $params)
    {
        $db = Database::connect();
        try {
            $db->connect();
            CLI::write("Connected successfully to " . $db->getDatabase(), 'green');
        } catch (\Exception $e) {
            CLI::error("Connection failed: " . $e->getMessage());
            CLI::write("Hostname: " . $db->hostname);
            CLI::write("Username: " . $db->username);
            CLI::write("Database: " . $db->database);
            CLI::write("Driver: " . $db->DBDriver);
        }
    }
}
