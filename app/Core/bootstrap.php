<?php

// Load the composer autoloader
require '../vendor/autoload.php';


use App\Models\User;

$users = (new User())->all();

echo '<pre>';
print_r($users);
echo '</pre>';
