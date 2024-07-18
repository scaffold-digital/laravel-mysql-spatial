<?php

namespace Stubs;

class PDOStub extends \PDO
{
    public function __construct(string $driver = 'mysql')
    {
        if ($driver !== 'mysql') {
            return;
        }

        $dsn = 'mysql:dbname=spatial_test;host=127.0.0.1';
        $username = 'root';
        $password = 'password';

        parent::__construct($dsn, $username, $password);
    }
}
