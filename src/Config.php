<?php
namespace VoicesTest;

use Exception;

final class Config {
    private static $config = [];

    public static function read(string $key = null):array|string {
        if(empty(self::$config)){
            $database_config_file = __DIR__ . "/../config/config.ini";
    
            if(!file_exists($database_config_file)){
                throw new Exception("Database config file '{$database_config_file}' does not exist. Please create it.");
            }
    
            self::$config = parse_ini_file($database_config_file);
        }

        if($key) {
            return self::$config[$key]??null;
        }

        return self::$config;
    }
}