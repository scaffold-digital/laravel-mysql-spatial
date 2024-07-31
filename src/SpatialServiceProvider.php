<?php

namespace ScaffoldDigital\LaravelMysqlSpatial;

use Doctrine\DBAL\Types\Type as DoctrineType;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Support\Facades\DB;
use ScaffoldDigital\LaravelMysqlSpatial\Connectors\ConnectionFactory;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\Geometry;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\GeometryCollection;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\LineString;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\MultiLineString;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\MultiPoint;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\MultiPolygon;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\Point;
use ScaffoldDigital\LaravelMysqlSpatial\Doctrine\Polygon;

/**
 * Class DatabaseServiceProvider.
 */
class SpatialServiceProvider extends DatabaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $this->app->singleton('db.schema', function ($app) {
            return $app['db']->connection()->getSchemaBuilder();
        });

        if (class_exists(DoctrineType::class)) {
            // Prevent geometry type fields from throwing a 'type not found' error when changing them
            $geometries = [
                'geometry'           => Geometry::class,
                'point'              => Point::class,
                'linestring'         => LineString::class,
                'polygon'            => Polygon::class,
                'multipoint'         => MultiPoint::class,
                'multilinestring'    => MultiLineString::class,
                'multipolygon'       => MultiPolygon::class,
                'geometrycollection' => GeometryCollection::class,
                'geomcollection'     => GeometryCollection::class,
            ];

            foreach ($geometries as $type => $class) {
                DB::registerDoctrineType($class, $type, $type);
                DB::connection()->registerDoctrineType($class, $type, $type);
            }
        }
    }
}
