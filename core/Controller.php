<?php
namespace core;

class Controller {

    public function view($response) {

        $response->generarVista();
    }
    
    public function redirect($url) {
        header("Location: ".getUrl($url));
    }

}