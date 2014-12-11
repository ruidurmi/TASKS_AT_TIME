<?php
namespace app\controllers;

use app\models\perfumesModel;
use core\ResponseJson;

class perfumes extends \core\Controller {
    
    public function listado(){
        $perfumesModel = new perfumesModel();
        $perfumes = $perfumesModel->getPerfumes();
        
        $this->view(new ResponseJson($perfumes));
    }
    
}
