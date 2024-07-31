<?php

use PHPUnit\Framework\TestCase;
use ScaffoldDigital\LaravelMysqlSpatial\MysqlConnection;
use ScaffoldDigital\LaravelMysqlSpatial\Schema\Builder;
use Tests\Unit\Stubs\PDOStub;

class MysqlConnectionTest extends TestCase
{
    private $mysqlConnection;

    protected function setUp(): void
    {
        $mysqlConfig = ['driver' => 'mysql', 'prefix' => 'prefix', 'database' => 'database', 'name' => 'foo'];
        $this->mysqlConnection = new MysqlConnection(new PDOStub('mysql'), 'database', 'prefix', $mysqlConfig);
    }

    public function testGetSchemaBuilder()
    {
        $builder = $this->mysqlConnection->getSchemaBuilder();

        $this->assertInstanceOf(Builder::class, $builder);

        \Mockery::close();
    }
}
