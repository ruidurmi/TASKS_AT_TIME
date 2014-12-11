<?php

namespace app\controllers;

use app\models\ingredientesModel;
use core\Response;
use core\ResponseJson;

class ingredientes extends \core\Controller {

    public function index() {

        $datos = array("nombre" => "chema");
        $this->view(new Response("main:ingredientes:index", $datos));
    }

    public function listado() {

        $ingredientes = new ingredientesModel();
        $lista = $ingredientes->getIngredientes();
        $datos = array("ingredientes" => $lista, "titulo" => "Listado de ingredientes");
        $this->view(new Response("main:ingredientes:listado", $datos));
    }

    public function mostrar($id) {

        $modelo = new ingredientesModel();
        $ingrediente = $modelo->getIngrediente($id);
        $datos = array("ingrediente" => $ingrediente, "titulo" => "Datos de " . $ingrediente["nombre_esp"]);
        $this->view(new Response("main:ingredientes:mostrar", $datos));
    }

    public function listar($id1, $id2) {
        $datos = array("id1" => $id1, "id2" => $id2);
        $this->view(new ResponseJson($datos));
    }

    public function editar($id, $request) {

        $modelo = new ingredientesModel();
        $datos = $modelo->getById($id);
        $form = new \app\models\IngredientesForm($request,$datos);

        if($form->isValid()){
//            Modificar en la base de datos
            $this->redirect("ingredientes/listado");
        }
        
        $datos = array("form" => $form->render());
        $this->view(new Response("main:ingredientes:form", $datos));
    }
    
    public function anadir($request) {

        $form = new \app\models\IngredientesForm($request);

        if($form->isValid()){
//            Insertar en la base de datos
            $this->redirect("ingredientes/listado");
        }
        
        $datos = array("form" => $form->render());
        $this->view(new Response("main:ingredientes:form", $datos));
    }

    public function eliminar($id) {
        
    }

}
