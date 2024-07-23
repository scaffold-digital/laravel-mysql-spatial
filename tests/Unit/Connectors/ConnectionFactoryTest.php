<?php

namespace Tests\Unit\Connectors;

use Illuminate\Container\Container;
use Mockery;
use ScaffoldDigital\LaravelMysqlSpatial\Connectors\ConnectionFactory;
use ScaffoldDigital\LaravelMysqlSpatial\MysqlConnection;
use Tests\TestCase;

class ConnectionFactoryTest extends TestCase
{
    public function testMakeCallsCreateConnection()
    {
        $pdo = $this->createMock(\PDO::class);

        $factory = Mockery::mock(ConnectionFactory::class, [new Container()])->makePartial();
        $factory->shouldAllowMockingProtectedMethods();
        $conn = $factory->createConnection('mysql', $pdo, 'database');

        $this->assertInstanceOf(MysqlConnection::class, $conn);
    }

    public function testCreateConnectionDifferentDriver()
    {
        $pdo = $this->createMock(\PDO::class);

        $factory = Mockery::mock(ConnectionFactory::class, [new Container()])->makePartial();
        $factory->shouldAllowMockingProtectedMethods();
        $conn = $factory->createConnection('pgsql', $pdo, 'database');

        $this->assertInstanceOf(\Illuminate\Database\PostgresConnection::class, $conn);
    }
}
