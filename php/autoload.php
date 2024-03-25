<?php
spl_autoload_register(function($class){
    
    $class_parts = explode("\\", $class);

    if($class_parts[0] == 'VoicesTest'){
        array_shift($class_parts);

        $class_file = __DIR__ . "/../src/" . implode("/", $class_parts) . ".php";

        if(file_exists($class_file)){
            require_once $class_file;
        }
    }

    return false;
});