<?php

namespace core;

//require_once 'app/Config.php';

/**
 * Description of Routing
 *
 * @author Chema
 */
class Routing {

    private $parametros = array();
    private $url = "";

    public function __construct() {

        $requestURI = explode("/", urldecode($_SERVER["REQUEST_URI"]));
        $scriptName = explode("/", $_SERVER["SCRIPT_NAME"]);

//        echo "<pre>";
//        print_r($_SERVER);
//        echo "</pre>";

        $parametros = array();

        foreach ($requestURI as $indice => $param) {
            if (isset($scriptName[$indice])) {
                if ($param !== $scriptName[$indice] and $param !== "index.php") {
                    array_push($parametros, $param);
                }
            } else if ($param !== "index.php") {
                array_push($parametros, $param);
            }
        }

        $this->url = implode("/", $parametros);
        $this->parametros = $parametros;
    }

    public function gerParametros() {
        return $this->parametros;
    }

    public function getParametro($indice) {
        return isset($this->parametros[$indice]) ? $this->parametros[$indice] : "";
    }

    public function getAccion() {

        $rutas = \app\Config::$rutas;
        $url = $this->url;

        $coincidencia = false;

        foreach ($rutas as $uri => $ruta) {
//            echo "Config $uri --> $url<br>";

            $uriArr = explode("/", $uri);
            $urlArr = explode("/", $url);
            $rutaArr = explode("/", $ruta);

            $coincidencia = true;
            $listaParametros = array();
            foreach ($uriArr as $i => $parametro) {

                if (isset($urlArr[$i])) {
//                    echo "  - param: $parametro --> $urlArr[$i]<br>";

                    if (preg_match("/{:/", $parametro)) {
                        $parametro = str_replace("{:", "", $parametro);
                        $parametro = str_replace("}", "", $parametro);
                        $this->parametrosValidos($parametro, $urlArr[$i], $coincidencia);
                        if ($coincidencia) {
                            $listaParametros[$rutaArr[$i]] = $parametro;
                        }
                    }

                    if ($urlArr[$i] !== $parametro) {
                        $coincidencia = false;
                    }
                } else {
                    $coincidencia = false;
                }
            }

            if ($coincidencia) {
                return $this->prepararLLamada($ruta, $listaParametros);
            }
        }
        return null;
    }

    private function parametrosValidos(&$parametro, $url, &$coincidencia) {
        switch ($parametro) {
            case "num":
                if (is_numeric($url)) {
                    $parametro = $url;
                } else {
//                    echo "No son del mismo tipo<br>";
                    $coincidencia = false;
                }
                break;
            case "text":
                if (is_string($url)) {
                    $parametro = $url;
                } else {
//                    echo "No son del mismo tipo<br>";
                    $coincidencia = false;
                }
                break;
            case "any":
                $parametro = $url;
                break;
        }
    }

    private function prepararLLamada($ruta, $listaParametros) {
        $rutaArr = explode("/", $ruta);
        $llamada = array("controlador" => $rutaArr[0], "metodo" => $rutaArr[1]);
        foreach ($listaParametros as $k => $v) {
            $llamada[$k] = $v;
        }
        return $llamada;
    }

}
