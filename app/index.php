<?php

set_include_path("./src");
require_once("credentials.php");
require_once("const.php");
require_once("Router.php");

StorageFactory::getInstance()->setStorageType(STORAGE_BDD);

$router = Router::getInstance();
$router->main();