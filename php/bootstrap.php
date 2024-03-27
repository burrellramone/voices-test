<?php
require_once(__DIR__ . "/autoload.php");

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . "/../templates/");

define("DOCUMENT_ROOT", __DIR__ . "/..");
define("ADMIN_EMAIL", VoicesTest\Config::read('admin_email'));
