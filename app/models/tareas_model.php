<?php
namespace app\models;

class tareas_model extends \core\Model{
    
    public function __construct() {
        parent::__construct("tareas");
    }
    
    public function getTareas(){
        
        return $this->get("tareas");
        
    }
    
    public function getTarea($id){
        
        return $this->from("tareas")
                ->where(array("id"=>$id))
                ->getSingleResult();
        
    }
    
    public function insertarTarea($tabla, $campos){
        
        $this->insert($tabla, $campos); 
        
    }
    

    
}
