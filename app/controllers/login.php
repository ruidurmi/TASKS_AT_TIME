<?php

namespace app\controllers;

use core\Response;
use core\seguridad\Seguridad;
//use app\Config;

class login extends \core\Controller {

    public function index() {
//        require_once '../Config.php';
        $seguridad = new Seguridad(true);
        $resultado = $seguridad->comprobarLogin();
//        var_dump($resultado);
        if ($resultado) {
            if ($resultado["resultado"] == "OK") {
                $this->redirect("calendario");
            }
        }
        $this->view(new Response("main:login:index"));
    }

    public function logout() {
        $seguridad = new Seguridad();
        $seguridad->logout();
        $this->redirect(getUrl(""));
    }

    public function login() {
        $seguridad = new Seguridad();
        $resultado = $seguridad->comprobarLogin();
        if ($resultado) {
            if ($resultado["resultado"] == "OK") {
                $this->redirect("home");
            }
        }
        $this->view(new \core\Response(":login:index", array("resultado" => $resultado)));
    }

}
