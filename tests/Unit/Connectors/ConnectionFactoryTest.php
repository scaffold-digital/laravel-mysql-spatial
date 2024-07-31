<?php

namespace Tests\Unit\Connectors;

use Illuminate\Container\Container;
use Mockery;
use ScaffoldDigital\LaravelMysqlSpatial\Connectors\ConnectionFactory;
use ScaffoldDigital\LaravelMysqlSpatial\MysqlConnection;
use Tests\TestCase;
use Tests\Unit\Stubs\PDOStub;

class ConnectionFactoryTest extends TestCase
{
    public function testMakeCallsCreateConnection()
    {
        $pdo = new PDOStub();

        $factory = Mockery::mock(ConnectionFactory::class, [new Container()])->makePartial();
        $factory->shouldAllowMockingProtectedMethods();
        $conn = $factory->createConnection('mysql', $pdo, 'database');

        $this->assertInstanceOf(MysqlConnection::class, $conn);
    }

    public function testCreateConnectionDifferentDriver()
    {
        $pdo = new PDOStub('pgsql');

        $factory = Mockery::mock(ConnectionFactory::class, [new Container()])->makePartial();
        $factory->shouldAllowMockingProtectedMethods();
        $conn = $factory->createConnection('pgsql', $pdo, 'database');

        $this->assertInstanceOf(\Illuminate\Database\PostgresConnection::class, $conn);
    }
}
