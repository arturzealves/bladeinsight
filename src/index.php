<?php

require dirname(__DIR__).'/vendor/autoload.php';

use BladeInsight\Application\Router;

$router = new Router();
$router->processRequest($_SERVER["REQUEST_URI"], $_REQUEST);

?>
