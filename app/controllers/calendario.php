<?php

namespace app\controllers;
use app\models\tareas_model;
use core\Response;

class calendario extends \core\Controller {

    public function index() {
        
        $seguridad = new \core\seguridad\Seguridad();
        if($seguridad->isAutenticado()){
            $this->view(new Response("main:calendario:index"));
        }else{
            $this->redirect("login");
        }
       
       
    }
    
    
    public function tareas() {
       
        $tareas = new tareas_model();
        $datos = $tareas->getTareas();
    
//        var_dump($datos);
        $this->view(new Response("main:calendario:index", array("tareas"=>$datos)));
        
    }
    
    public function insertarTarea() {
       
//        $nombre = isset($_POST[""]) ? $_POST["nombre"] : "";
//        
//        $fecha_inicio=isset($_POST[""]) ? $_POST["nombre"] : "";
        $tabla="tareas";
        $campos=array("0"=>"Miriam","1"=>"Ruiz","2"=> 1234,"3"=> "miriam@gmail.com","4"=> 915555555);        
//        echo("{nombre: \"miguel\"}");
//        echo("{nombre: \"miguel\"}");
        $model = new tareas_model;
        $model->insertarTarea($tabla, $campos);     
    }

}
     
