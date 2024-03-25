<?php
namespace VoicesTest;

require __DIR__ . '/../php/bootstrap.php';

use Exception;
use Error;
use ErrorException;

try {
    $e = null;

    return (new App())->execute();

} catch (Exception $e) {
} catch (Error $e) {
} catch (ErrorException $e) {
} finally {
    if ($e) {
        die("Error:" . $e->getMessage());
    }
}