<?php

namespace App\Controllers;

use Config\Database;

class DbCheck extends BaseController
{
    public function index()
    {
        $db = Database::connect();
        try {
            $db->connect();
            echo "Connected successfully to " . $db->getDatabase();
        } catch (\Exception $e) {
            echo "Connection failed: " . $e->getMessage();
            echo "\nHostname: " . $db->hostname;
            echo "\nUsername: " . $db->username;
            echo "\nDatabase: " . $db->database;
            echo "\nDriver: " . $db->DBDriver;
        }
    }
}
