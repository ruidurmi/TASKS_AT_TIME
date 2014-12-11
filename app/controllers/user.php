<?php
namespace app\controllers;

use core\Controller;
use core\seguridad\Seguridad;

class user extends Controller {

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
                $this->redirect("ingredientes/");
            }
        }
        $this->view(new \core\Response(":user:login",array("resultado"=>$resultado)));
    }

}
