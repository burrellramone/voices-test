<?php
namespace VoicesTest;

use PDO;
use Exception;

final class Database {
    private static ?PDO $connection = null;

    public static function getInstance():PDO {
        if (!isset(self::$connection)) {
            
            $config = Config::read();

            $database = $config['database'];
            $host = $config['host'];
            $username = $config['user'];
            $password = $config['password'];
    
            $dsn = "mysql:dbname={$database};host={$host};user={$username};password={$password}";

            self::$connection = new PDO($dsn);
        }

        return self::$connection;
    }
}