<?php

namespace ScaffoldDigital\LaravelMysqlSpatial;

use Doctrine\DBAL\Types\Type as DoctrineType;
use Illuminate\Database\MySqlConnection as IlluminateMySqlConnection;
use Illuminate\Support\Facades\DB;
use ScaffoldDigital\LaravelMysqlSpatial\Schema\Builder;
use ScaffoldDigital\LaravelMysqlSpatial\Schema\Grammars\MySqlGrammar;

class MysqlConnection extends IlluminateMySqlConnection
{
    public function __construct($pdo, $database = '', $tablePrefix = '', array $config = [])
    {
        parent::__construct($pdo, $database, $tablePrefix, $config);

        try {
            if (class_exists(DoctrineType::class) && DB::connection()->getPdo()) {
                // Prevent geometry type fields from throwing a 'type not found' error when changing them
                $geometries = [
                    'geometry',
                    'point',
                    'linestring',
                    'polygon',
                    'multipoint',
                    'multilinestring',
                    'multipolygon',
                    'geometrycollection',
                    'geomcollection',
                ];
                $dbPlatform = $this->getDoctrineSchemaManager()->getDatabasePlatform();
                foreach ($geometries as $type) {
                    $dbPlatform->registerDoctrineTypeMapping($type, 'string');
                }
            }
        } catch (\Exception $e) {
            // no db connection
        }
    }

    /**
     * Get the default schema grammar instance.
     *
     * @return \Illuminate\Database\Grammar
     */
    protected function getDefaultSchemaGrammar()
    {
        return $this->withTablePrefix(new MySqlGrammar());
    }

    /**
     * Get a schema builder instance for the connection.
     *
     * @return \Illuminate\Database\Schema\MySqlBuilder
     */
    public function getSchemaBuilder()
    {
        if (is_null($this->schemaGrammar)) {
            $this->useDefaultSchemaGrammar();
        }

        return new Builder($this);
    }
}
