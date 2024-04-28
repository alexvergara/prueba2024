<?php

require_once 'ErrorHandler.php';

// Set the error handler
set_error_handler("ErrorHandler::handleError");
set_exception_handler("ErrorHandler::handleException");

// Load the composer autoloader
require '../vendor/autoload.php';

// Load routes file
require '../routes/api.php';
