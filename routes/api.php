<?php

use App\Core\Router;

$prefix = 'API\\v1\\'; # API Version 1, this will be used as a prefix for all routes (e.g. /api/v1/users)

# User Routes
Router::get('/users', 'UserController', 'index', $prefix);
Router::get('/users/{id}', 'UserController', 'show', $prefix);
Router::post('/users', 'UserController', 'store', $prefix);
Router::put('/users/{id}', 'UserController', 'update', $prefix);
Router::delete('/users/{id}', 'UserController', 'destroy', $prefix);


# Transfer Routes
// Router::get('/transfers', 'TransferController', 'index', $prefix);
// Router::get('/transfers/{id}', 'TransferController', 'show', $prefix);
Router::post('/transfers', 'TransferController', 'store', $prefix);
// Router::put('/transfers/{id}', 'TransferController', 'update', $prefix);
// Router::delete('/transfers/{id}', 'TransferController', 'destroy', $prefix);


# 404 Route fallback
Router::get('_404', 'Controller');
