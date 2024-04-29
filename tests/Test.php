<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    private $pdo;

    public function setUp(): void
    {
        // Create an in-memory SQLite database
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create database schema
        $this->createSchema();
    }

    public function tearDown(): void
    {
        // Close the database connection
        $this->pdo = null;
    }

    private function createSchema(): void
    {
        $folder = './database/migrations/';
        $migrations = glob($folder . '*.sql');

        foreach ($migrations as $migration) {
            $sql = convertDDLToSQLite(file_get_contents($migration));
            $this->pdo->exec($sql);
        }

        $folder = './database/seeds/';
        $migrations = glob($folder . '*.sql');

        foreach ($migrations as $migration) {
            $sql = file_get_contents($migration);
            $this->pdo->exec($sql);
        }
    }

    public function testMigration(): void
    {
        // Use $this->pdo to interact with the in-memory database
        $stmt = $this->pdo->query('SELECT COUNT(*) FROM users');
        $this->assertEquals(4, $stmt->fetchColumn());
    }
}
