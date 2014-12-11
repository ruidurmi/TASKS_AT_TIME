<?php

define("BASEURL", str_replace("/index.php", "", $_SERVER["SCRIPT_NAME"]));

require_once 'core/Autoloader.php';
$autoload = new \core\Autoloader();

//require_once 'core/Routing.php';
$routing = new \core\Routing();
$accion = $routing->getAccion();

//require_once 'core/Distribuidor.php';
core\Distribuidor::request($accion);