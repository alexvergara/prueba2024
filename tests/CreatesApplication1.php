<?php

namespace Tests;

trait CreatesApplication
{
    public function createApplication()
    {
        $app = require __DIR__.'/../app/Core/bootstrap.php';

        return $app;
    }
}
