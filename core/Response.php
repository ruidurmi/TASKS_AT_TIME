<?php

namespace core;

class Response {

    private $content = null;
    private $datos = null;
    private $buffer = null;

    public function __construct($vistas, $datos = array()) {
        $vistaArr = explode(":", $vistas);
        $layout = $vistaArr[0];
        $controlador = $vistaArr[1];
        $vista = $vistaArr[2];



        if ($datos) {
            foreach ($datos as $k => $v) {
                $$k = $v;
            }
        }

        if ($layout) {

            ob_start();
            include_once "app/views/$controlador/$vista.php";

            $content = ob_get_clean();

            ob_start();
            include_once "app/views/layouts/$layout.php";
            $this->buffer = ob_get_flush();
        } else {
            include_once "app/views/$controlador/$vista.php";
        }
    }

    public function generarVista() {
//        header('Content-Type: text/plain');
//        header('Content-Type: text/html');
        return $this->buffer;
    }

}
