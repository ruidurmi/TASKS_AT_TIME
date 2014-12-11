<?php

namespace core;

require_once 'app/Config.php';
require_once 'funcionesGenerales.php';

use core\seguridad\Seguridad;

/**
 * Description of Distribuidor
 *
 * @author Chema
 */
class Distribuidor {

    private static $controlador;
    private static $metodo;
    private static $clase;
    private static $servicio;
    private static $parametros;

    public static function request($accion) {

//        echo Config::$host." de<br>";

        $usuario = new Users();
        $request = new Request();

        if (!$accion) {
//            header("Location: " . BASEURL . "/Error404.php");
            include __DIR__ . '/../Error404.php';
            exit();
        }

        if (\app\Config::$usuario != "") {
            if ($accion["controlador"] !== "login" && $accion["metodo"] !== "index") {
                $seguridad = new Seguridad();
                if (!$seguridad->isAutenticado()) {
                    header("Location: " . getUrl("login"));
                }
            }
        }

        // Comprobación de seguridad. Si necesita estar autenticado o no para
        // acceder a los contenidos.
//        if (Config::$usuario && Config::$password) {
//            if (!$usuario->estaAutenticado()) {
//                echo "AUTENTIFICACION REQUERIDA";
//                return false;
//            }
//        }

        $controlador = $accion["controlador"];
        $metodo = $accion["metodo"];
        $parametros = "";
        foreach ($accion as $k => $v) {
            if ($k !== "controlador" && $k !== "metodo") {
                $parametros .= $v . ",";
            }
        }
        $parametros = substr($parametros, 0, strlen($parametros) - 1);
        self::$parametros = $parametros;
        require_once 'Controller.php';
        if (file_exists("app/controllers/$controlador.php")) {
//            require_once "app/controllers/$controlador.php";
            $controladorNamespace = "app\\controllers\\$controlador";
            if (class_exists($controladorNamespace, true)) {

                $obj = new $controladorNamespace();
                if (method_exists($obj, $metodo)) {

                    self::$controlador = $controlador;
                    self::$metodo = $metodo;

                    if ($parametros) {
                        $ejecutar = "\$obj->\$metodo($parametros, \$request);";
                    } else {
                        $ejecutar = "\$obj->\$metodo(\$request);";
                    }
                    eval($ejecutar);
                } else {
                    die("No existe el método $metodo de la clase $controladorNamespace.");
                }
            } else {
                die("No existe la clase $controladorNamespace.");
            }
        } else {
            die("No existe el fichero $controlador.php.");
        }
    }

//    public static function login() {
//
//        $user = isset($_POST["user"]) ? $_POST["user"] : "";
//        $password = isset($_POST["password"]) ? $_POST["password"] : "";
//
//        if ($user && $password) {
//            $usuario = new core\Users();
//            return $usuario->login($user, $password);
//        } else {
//            return false;
//        }
//    }

    public static function getControlador() {
        return self::$controlador;
    }

    public static function getMetodo() {
        return self::$metodo;
    }

    public static function getParametros(){
        return self::$parametros;
    }
    
}
