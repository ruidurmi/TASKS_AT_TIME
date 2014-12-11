<?php
namespace app\models;

class perfumesModel extends \core\Model {
    
    public function getPerfumes(){
        return $this->get("perfumes");
    }
    
    public function getPerfume($id){
        return $this->from("perfumes")->where("id=$id")
                ->getSingleResult();
    }
    
}
