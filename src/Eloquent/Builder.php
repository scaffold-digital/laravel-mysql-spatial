<?php

namespace ScaffoldDigital\LaravelMysqlSpatial\Eloquent;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use ScaffoldDigital\LaravelMysqlSpatial\Types\GeometryInterface;

class Builder extends EloquentBuilder
{
    public function update(array $values)
    {
        foreach ($values as $key => &$value) {
            if ($value instanceof GeometryInterface) {
                $value = $this->asWKT($value);
            }
        }

        return parent::update($values);
    }

    protected function asWKT(GeometryInterface $geometry)
    {
        return new SpatialExpression($geometry);
    }
}
