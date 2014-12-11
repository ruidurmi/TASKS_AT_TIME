<?php
namespace app\models;

class ingredientesModel extends \core\Model{
    
    public function __construct() {
        parent::__construct("ingredientes");
    }
    
    public function getIngredientes(){
        
        return $this->get("ingredientes");
        
    }
    
    public function getIngrediente($id){
        
        return $this->from("ingredientes")
                ->where(array("id"=>$id))
                ->getSingleResult();
        
    }
    
}