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
