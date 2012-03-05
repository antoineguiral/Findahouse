<?php

namespace Findahouse\mongo;

/**
 * Class responsible for the Mongo connection
 */
class Mongo {

    /**
     *
     * @var \Mongo
     */
    protected static $connection;

    /**
     * Private construct for singleton pattern.
     */
    private function __construct() {
        
    }

    /**
     * Returns a singleton instance of Mongo connection
     * 
     * @return \Mongo
     */
    public static function getConnection() {
        if (!isset(self::$connection)) {
            try {
                $mongo = new \Mongo("mongodb://127.0.0.1:27017");

                self::$connection = $mongo;
            } catch (\Exception $e) {
                error_log($e->getMessage());
            }
        }

        return self::$connection;
    }

}