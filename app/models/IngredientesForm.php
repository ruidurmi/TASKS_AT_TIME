<?php
namespace app\models;

class IngredientesForm extends \core\Formulario {

    public function setConfig(){
        
        $this->campos = array(
            "id" => array("type"=>"hidden"),
            "nombre_esp" => array("label" => "Nombre esp", "type" => "text"),
            "nombre_cat" => array("label" => "Nombre cat", "type" => "text"),
            "nombre_eng" => array("label" => "Nombre eng", "type" => "text"),
            "familia" => array("type" => "select",
                "choices"=>array("afrutada" => "Afrutada","amaderada" => "Amaderada","mentada" => "Mentada","floral" => "Floral","fresca" => "Fresca"),
//                "multiple" => true,
                "expandido" => true
                ),
            "Enviar" => array("type" => "submit"),
        );
        
    }
    
    public function setValidaciones() {
        $this->validaciones = array(
            "nombre_esp"=>array("requerido"=>true,"length"=>20),
            "nombre_cat"=>array("requerido"=>true,"length"=>20),
            "nombre_eng"=>array("requerido"=>true,"length"=>20),
//            "familia"=>array("requerido"=>true,"length"=>10),
        );
    }
    
}
