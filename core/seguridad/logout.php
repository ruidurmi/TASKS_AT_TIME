<?php
require_once __DIR__ . '/seguridad.php';
$seguridad = new Seguridad();
$resultado = $seguridad->logout();

echo "Logout";