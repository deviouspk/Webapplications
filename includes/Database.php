<?php
ini_set('mongo.long_as_object', 1);
require_once __DIR__ . "/vendor/autoload.php";

class Database
{

    /* DB connection */
    private static $connection;

    /* Config File */
    private static $config;
    
    public static function connect()
    {
        if (!isset(self::$connection)) {
            self::getConfig();
            try {
                self::$connection = new MongoDB\Client('mongodb://' . self::$config['host'] . ':' . self::$config['port'] . '/' . self::$config['authdb'],
                    array('username' => self::$config['username'], 'password' => self::$config['password'], 'replicaSet' => false, 'connect' => false),
                    ['typeMap' => ['root' => 'array', 'document' => 'array', 'array' => 'array']]);
            } catch(MongoConnectionException $e) {
                trigger_error('Mongodb not available', E_USER_ERROR);
                die();
            }

        }

        //TODO ERROR HANDLING

        return self::$connection;
    }

    public static function getConfig()
    {

        if (self::$config == null) {
            self::$config = parse_ini_file('config.ini');
        }

        return self::$config;
    }

    
}


?>