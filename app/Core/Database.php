<?php

// Path: app/Core/Database.php

namespace App\Core;

use PDO;

class Database
{
    /**
     * Database connection
     */
    private $dbConnection = null;

    /**
     * Create a new PDO connection
     *
     * @return void
     */
    public function __construct()
    {
        // Load the database configuration
        $config = require(__DIR__ . '/../../config/database.php');

        try {
            // Create a new PDO dsn connection using http_build_query to build the query string
            $dsn = 'mysql:' . http_build_query($config['uri'], '', ';');

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // PDO::FETCH_OBJ,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            $this->dbConnection = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * Get the database connection
     *
     * @return PDO
     */
    public function getConnection()
    {
        return $this->dbConnection;
    }
}
