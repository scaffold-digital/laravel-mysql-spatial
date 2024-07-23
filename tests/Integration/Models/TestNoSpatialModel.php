<?php

namespace Tests\Integration\Models;

use Illuminate\Database\Eloquent\Model;
use ScaffoldDigital\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class TestNoSpatialModel extends Model
{
    use SpatialTrait;
}
