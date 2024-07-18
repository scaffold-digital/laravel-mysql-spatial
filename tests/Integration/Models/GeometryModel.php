<?php

use Illuminate\Database\Eloquent\Model;
use ScaffoldDigital\LaravelMysqlSpatial\Eloquent\SpatialTrait;

/**
 * Class GeometryModel.
 *
 * @property int                                          id
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\Point      location
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\LineString line
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\LineString shape
 */
class GeometryModel extends Model
{
    use SpatialTrait;

    protected $table = 'geometry';

    protected $spatialFields = ['location', 'line', 'multi_geometries'];
}
