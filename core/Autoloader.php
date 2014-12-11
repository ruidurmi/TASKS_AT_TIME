<?php
namespace core;

/**
 * Description of Autoloader
 *
 * @author JoseMaria
 */
class Autoloader {
    
    public function __construct() {
        spl_autoload_register(array($this,"cargar"));
    }
    
    public static function cargar($fichero){
        
        $nombre = str_replace("\\", "/", $fichero);
        require_once "$nombre.php";
        
    }
    
}
