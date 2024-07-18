<?php

use Illuminate\Database\Eloquent\Model;
use ScaffoldDigital\LaravelMysqlSpatial\Eloquent\SpatialTrait;

/**
 * Class WithSridModel.
 *
 * @property int                                          id
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\Point      location
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\LineString line
 * @property \ScaffoldDigital\LaravelMysqlSpatial\Types\LineString shape
 */
class WithSridModel extends Model
{
    use SpatialTrait;

    protected $table = 'with_srid';

    protected $spatialFields = ['location', 'line'];

    public $timestamps = false;
}
