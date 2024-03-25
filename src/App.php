<?php
namespace VoicesTest;

use VoicesTest\Controller\Jobs;
use VoicesTest\Controller\NotFound;

final class App {
    public function execute(){

        $path = $_SERVER['REQUEST_URI'];

        // Serve static assets as is
        if (preg_match('@^/assets/?@', $path)) {
            return false;
        }

        $parts = explode("/", $path);
        $parts = array_values(array_filter($parts));
        $action = 'index';

        if(!$parts || $parts[0] == 'jobs'){
            $controller = new Jobs();
        } else {
            $controller = new NotFound();
        }

        if(!($controller instanceof NotFound) && isset($parts[1])) {
            $action = $parts[1];
        }

        $controller->sendHeaders();
        echo $controller->{$action}();

        return true;
    }
}