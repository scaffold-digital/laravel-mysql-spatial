<?php

namespace Tests\Integration\Models;

use Illuminate\Database\Eloquent\Model;
use ScaffoldDigital\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class TestModel extends Model
{
    use SpatialTrait;

    protected $spatialFields = ['point'];

    public $timestamps = false;

    public static $pdo;

    public function testrelatedmodels()
    {
        return $this->hasMany(TestRelatedModel::class);
    }

    public function testrelatedmodels2()
    {
        return $this->belongsToMany(TestRelatedModel::class);
    }
}
