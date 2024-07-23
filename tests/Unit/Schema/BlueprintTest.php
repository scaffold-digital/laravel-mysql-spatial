<?php

namespace Tests\Unit\Schema;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Mockery;
use Tests\TestCase;

class BlueprintTest extends TestCase
{
    protected $blueprint;

    public function setUp(): void
    {
        parent::setUp();

        $this->blueprint = Mockery::mock(Blueprint::class)
            ->makePartial()->shouldAllowMockingProtectedMethods();
    }

    public function testGeometry()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => null,
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => null, 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->geometry('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testPoint()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'point',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'point', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->point('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testLinestring()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'linestring',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'linestring', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->lineString('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testPolygon()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'polygon',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'polygon', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->polygon('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiPoint()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multipoint',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multipoint', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiPoint('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiLineString()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multilinestring',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multilinestring', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiLineString('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiPolygon()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multipolygon',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multipolygon', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiPolygon('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testGeometryCollection()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'geometrycollection',
            'srid' => null,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'geometrycollection', 'srid' => null])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->geometryCollection('col');

        $this->assertSame($expectedCol, $result);
    }

    public function testGeometryWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => null,
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => null, 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->geometry('col', null, 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testPointWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'point',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'point', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->point('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testLinestringWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'linestring',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'linestring', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->lineString('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testPolygonWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'polygon',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'polygon', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->polygon('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiPointWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multipoint',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multipoint', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiPoint('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiLineStringWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multilinestring',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multilinestring', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiLineString('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testMultiPolygonWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'multipolygon',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'multipolygon', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->multiPolygon('col', 4326);

        $this->assertSame($expectedCol, $result);
    }

    public function testGeometryCollectionWithSrid()
    {
        $expectedCol = new ColumnDefinition([
            'type' => 'geometry',
            'name' => 'col',
            'subtype' => 'geometrycollection',
            'srid' => 4326,
        ]);

        $this->blueprint
            ->shouldReceive('addColumn')
            ->with('geometry', 'col', ['subtype' => 'geometrycollection', 'srid' => 4326])
            ->once()
            ->andReturn($expectedCol);

        $result = $this->blueprint->geometryCollection('col', 4326);

        $this->assertSame($expectedCol, $result);
    }
}
