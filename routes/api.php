<?php

use App\Core\Router;

$prefix = 'API\\v1\\'; # API Version 1, this will be used as a prefix for all routes (e.g. /api/v1/users)

# User Routes
Router::get('/users', 'UserController', 'index', $prefix);
Router::get('/users/{id}', 'UserController', 'show', $prefix);
Router::post('/users', 'UserController', 'store', $prefix);
Router::put('/users/{id}', 'UserController', 'update', $prefix);
Router::delete('/users/{id}', 'UserController', 'destroy', $prefix);


# Transaction Routes
// Router::get('/transactions', 'TransactionController', 'index', $prefix);
// Router::get('/transactions/{id}', 'TransactionController', 'show', $prefix);
Router::post('/transactions', 'TransactionController', 'store', $prefix);
// Router::put('/transactions/{id}', 'TransactionController', 'update', $prefix);
// Router::delete('/transactions/{id}', 'TransactionController', 'destroy', $prefix);


# 404 Route fallback
Router::get('_404', 'Controller');
