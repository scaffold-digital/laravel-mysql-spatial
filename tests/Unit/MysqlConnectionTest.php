<?php

namespace Tests\Unit\Types;

use Illuminate\Database\Schema\Builder;
use ScaffoldDigital\LaravelMysqlSpatial\MysqlConnection;
use Tests\TestCase;

class MysqlConnectionTest extends TestCase
{
    private $mysqlConnection;

    protected function setUp(): void
    {
        $mysqlConfig = ['driver' => 'mysql', 'prefix' => 'prefix', 'database' => 'database', 'name' => 'foo'];
        $this->mysqlConnection = new MysqlConnection($this->createMock(\PDO::class), 'database', 'prefix', $mysqlConfig);
    }

    public function testGetSchemaBuilder()
    {
        $builder = $this->mysqlConnection->getSchemaBuilder();

        $this->assertInstanceOf(Builder::class, $builder);

        \Mockery::close();
    }
}
