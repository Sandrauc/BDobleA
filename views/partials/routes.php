<?php

require(__DIR__ .'/../../vendor/autoload.php');

$dotenv = Dotenv\Dotenv::create(__DIR__ ."../../../");
$dotenv->load();

$baseURL = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/".$_ENV['ROOT_FOLDER'];

$adminlteURL = $baseURL."/vendor/almasaeed2010/adminlte";

?>