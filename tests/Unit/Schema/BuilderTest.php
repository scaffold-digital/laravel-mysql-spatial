<?php

namespace Tests\Unit\Schema;

use Mockery;
use ScaffoldDigital\LaravelMysqlSpatial\MysqlConnection;
use ScaffoldDigital\LaravelMysqlSpatial\Schema\Blueprint;
use ScaffoldDigital\LaravelMysqlSpatial\Schema\Builder;
use Tests\TestCase;

class BuilderTest extends TestCase
{
    public function testReturnsCorrectBlueprint()
    {
        $connection = Mockery::mock(MysqlConnection::class);
        $connection->shouldReceive('getSchemaGrammar')->once()->andReturn(null);

        $mock = Mockery::mock(Builder::class, [$connection]);
        $mock->makePartial()->shouldAllowMockingProtectedMethods();
        $blueprint = $mock->createBlueprint('test', function () {
        });

        $this->assertInstanceOf(Blueprint::class, $blueprint);
    }
}
