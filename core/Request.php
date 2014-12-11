<?php
namespace core;

class Request {
    
    public $get;
    public $post;
    
    public function __construct() {
        $this->get = $this->get();
        $this->post = $this->post();
    }
    
    public function get($indice = ""){
        if($indice){
            return isset($_GET[$indice]) ? $_GET[$indice] : "";
        }
        
        $get = array();
        foreach($_GET as $clave => $valor){
            $get[$clave] = $valor;
        }
        
        return $get;
    }
    
    public function post($indice = ""){
        if($indice){
            return isset($_POST[$indice]) ? $_POST[$indice] : "";
        }
        
        $post = array();
        foreach($_POST as $clave => $valor){
            $post[$clave] = $valor;
        }
        
        return $post;
        
    }
    
}
