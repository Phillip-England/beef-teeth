<?php

require_once __DIR__.'/vendor/autoload.php';

// loading in required local modules
include("./src/components/init.php");
include('./src/routes/init.php');
include("./src/database/init.php");
include("./src/utility/init.php");
include('./src/types/init.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$serverRouter = get_server_router();
$path = get_request_path();

// handling regular routes
$pageExists = array_key_exists($path, $serverRouter);
if ($pageExists) {
    $serverRouter[$path]();
} else {
    include("./src/views/error/404.php");
}


