<?php

namespace Tests\Integration;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use ScaffoldDigital\LaravelMysqlSpatial\Types\GeometryCollection;
use ScaffoldDigital\LaravelMysqlSpatial\Types\LineString;
use ScaffoldDigital\LaravelMysqlSpatial\Types\MultiPoint;
use ScaffoldDigital\LaravelMysqlSpatial\Types\MultiPolygon;
use ScaffoldDigital\LaravelMysqlSpatial\Types\Point;
use ScaffoldDigital\LaravelMysqlSpatial\Types\Polygon;
use Tests\Integration\Migrations\CreateTables;
use Tests\Integration\Migrations\UpdateTables;
use Tests\Integration\Models\WithSridModel;
use Tests\TestCase;

class SridSpatialTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        (new CreateTables)->up();
        (new UpdateTables)->up();
    }

    public function tearDown(): void
    {
        (new UpdateTables)->down();
        (new CreateTables)->down();

        parent::tearDown();
    }

    public function testInsertPointWithSrid()
    {
        $geo = new WithSridModel();
        $geo->location = new Point(1, 2, 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testInsertLineStringWithSrid()
    {
        $geo = new WithSridModel();

        $geo->location = new Point(1, 2, 3857);
        $geo->line = new LineString([new Point(1, 1), new Point(2, 2)], 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testInsertPolygonWithSrid()
    {
        $geo = new WithSridModel();

        $geo->location = new Point(1, 2, 3857);
        $geo->shape = Polygon::fromWKT('POLYGON((0 10,10 10,10 0,0 0,0 10))', 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testInsertMultiPointWithSrid()
    {
        $geo = new WithSridModel();

        $geo->location = new Point(1, 2, 3857);
        $geo->multi_locations = new MultiPoint([new Point(1, 1), new Point(2, 2)], 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testInsertMultiPolygonWithSrid()
    {
        $geo = new WithSridModel();

        $geo->location = new Point(1, 2, 3857);

        $geo->multi_shapes = new MultiPolygon([
            Polygon::fromWKT('POLYGON((0 10,10 10,10 0,0 0,0 10))'),
            Polygon::fromWKT('POLYGON((0 0,0 5,5 5,5 0,0 0))'),
        ], 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testInsertGeometryCollectionWithSrid()
    {
        $geo = new WithSridModel();

        $geo->location = new Point(1, 2, 3857);

        $geo->multi_geometries = new GeometryCollection([
            Polygon::fromWKT('POLYGON((0 10,10 10,10 0,0 0,0 10))'),
            Polygon::fromWKT('POLYGON((0 0,0 5,5 5,5 0,0 0))'),
            new Point(0, 0),
        ], 3857);
        $geo->save();
        $this->assertDatabaseHas('with_srid', ['id' => $geo->id]);
    }

    public function testUpdateWithSrid()
    {
        $geo = new WithSridModel();
        $geo->location = new Point(1, 2, 3857);
        $geo->save();

        $to_update = WithSridModel::all()->first();
        $to_update->location = new Point(2, 3, 3857);
        $to_update->save();

        $this->assertDatabaseHas('with_srid', ['id' => $to_update->id]);

        $all = WithSridModel::all();
        $this->assertCount(1, $all);

        $updated = $all->first();
        $this->assertInstanceOf(Point::class, $updated->location);
        $this->assertEquals(2, $updated->location->getLat());
        $this->assertEquals(3, $updated->location->getLng());
    }

    public function testInsertPointWithWrongSrid()
    {
        $geo = new WithSridModel();
        $geo->location = new Point(1, 2);

        $this->assertException(
            QueryException::class,
            'SQLSTATE[HY000]: General error: 3643 The SRID of the geometry ' .
                'does not match the SRID of the column \'location\'. The SRID ' .
                'of the geometry is 0, but the SRID of the column is 3857. ' .
                'Consider changing the SRID of the geometry or the SRID property ' .
                'of the column. (SQL: insert into `with_srid` (`location`) values ' .
                '(ST_GeomFromText(POINT(2 1), 0, \'axis-order=long-lat\')))'
        );
        $geo->save();
    }

    public function testGeometryInsertedHasRightSrid()
    {
        $geo = new WithSridModel();
        $geo->location = new Point(1, 2, 3857);
        $geo->save();

        $srid = DB::selectOne('select ST_SRID(location) as srid from with_srid');
        $this->assertEquals(3857, $srid->srid);

        $result = WithSridModel::first();

        $this->assertEquals($geo->location->getSrid(), $result->location->getSrid());
        $a = 1;
    }
}
