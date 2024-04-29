<?php

/**
 * ------------------------------
 * Helper functions
 */

/*
 * Debugging function
 * @param mixed $data
 * @param bool $die
 */
if (!function_exists('dd')) {
    function dd($data, $die = true)
    {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
        if ($die) die();
    }
}

/*
 * Extract uri path
 * @param string $uri
 * @param string $prefix
 * @return string
 */
if (!function_exists('uri_path')) {
    function uri_path(string $uri = '', string $prefix = ''): string
    {
        return str_replace(str_replace('\\', '/', strtolower($prefix)), '', $uri);
    }
}

/*
 * Convert MySQL DDL to SQLite DDL
 * @param string $mysqlDDL
 * @return string
 */
if (!function_exists('convertDDLToSQLite')) {
    function convertDDLToSQLite($mysqlDDL)
    {
        // Replace AUTO_INCREMENT with INTEGER PRIMARY KEY
        //$sqliteDDL = preg_replace('/"id"\s*BIGINT\s*UNSIGNED\s*NOT\s*NULL\s*INTEGER\s*PRIMARY\s*KEY\s*AUTOINCREMENT,/', '"id" INTEGER PRIMARY KEY AUTOINCREMENT,', $mysqlDDL);

        // Replace data types
        $sqliteDDL = str_replace('VARCHAR', 'TEXT', $mysqlDDL);
        $sqliteDDL = str_replace('INT', 'INTEGER', $sqliteDDL);
        $sqliteDDL = preg_replace('/DECIMAL\s*\(\s*(\d+)\s*,\s*(\d+)\s*\)/', 'DECIMAL($1, $2)', $sqliteDDL); // Adjust DECIMAL data type
        $sqliteDDL = preg_replace('/(.*?) ENUM\s*\(\s*([^)]+?)\s*\)/', '$1 TEXT CHECK($1 IN (\2))', $sqliteDDL); // Adjust ENUM data type
        $sqliteDDL = str_replace('DATETIME', 'TEXT', $sqliteDDL); // Convert DATETIME to TEXT for simplicity
        $sqliteDDL = str_replace('BIGINTEGER UNSIGNED NOT NULL AUTO_INCREMENT', 'INTEGER PRIMARY KEY AUTOINCREMENT', $sqliteDDL);

        // Remove the trailing comma before removing the last line containing PRIMARY KEY (`id`)
        $sqliteDDL = preg_replace('/,\s*PRIMARY KEY\s*\(`id`\)/', '', $sqliteDDL);
        $sqliteDDL = preg_replace('/,\s*FOREIGN KEY\s*\(`id`\)/', '', $sqliteDDL);
        $sqliteDDL = str_replace(' ON UPDATE CURRENT_TIMESTAMP', '', $sqliteDDL);

        // Replace backticks with double quotes for identifiers
        $sqliteDDL = str_replace('`', '"', $sqliteDDL);

        return $sqliteDDL;
    }
}
