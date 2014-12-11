<?php
namespace core;

class ResponseJson {

    private $datos = null;
    
    public function __construct($datos) {
        $this->datos = $datos;
    }
 
    public function generarVista(){
        header('Content-Type: application/json');
        echo json_encode($this->datos);
    }
    
}