<?php

namespace core;

use app\Config;

class Model extends BD {

//    public $tabla = "";

    public function __construct($tabla = "") {
        parent::__construct(Config::$host, Config::$user, Config::$pass, Config::$dataBase);

        if ($tabla) {
            $this->tabla = $tabla;
        } else {
            $this->tabla = get_class($this);
        }
    }

    /**
     * Hace una consulta a la base de datos y el resultado lo devuelve en forma
     * de array o de json si se indicado.
     * @param string $tabla Nombre de la Tabla.
     * @param string $limit Número de resultados que aparecerán.
     * @param string $offset Fila desde el que se mostrarán los datos.
     * @param boolean $json Dice si el resultado lo devolverá como un json o no.
     * @param boolean $utf8 Si es true se mostrarán los campos en formato utf8, si
     * no se mostrarán tal cual.
     * @return mixed Devuelve un array con el resultado obtenido o un json si 
     * se ha indicado al llamar a la función.
     */
    public function get($tabla = "", $limit = 0, $offset = 0, $json = false, $utf8 = false) {

        if (is_array($tabla)) {
            $params = $tabla;
            $json = isset($params["json"]) ? ($params["json"] === "true") ? true : false : $json;
            $utf8 = isset($params["utf8"]) ? $params["utf8"] : $utf8;
            $limit = isset($params["limit"]) ? $params["limit"] : $limit;
            $offset = isset($params["offset"]) ? $params["offset"] : $offset;
            $tabla = $this->tabla;
        }

        if (is_object($tabla)) {
            $params = $tabla->get();
            $json = isset($params["json"]) ? ($params["json"] === "true") ? true : false : $json;
            $utf8 = isset($params["utf8"]) ? $params["utf8"] : $utf8;
            $limit = isset($params["limit"]) ? $params["limit"] : $limit;
            $offset = isset($params["offset"]) ? $params["offset"] : $offset;
            $tabla = $this->tabla;
        }

        if (!$tabla) {
            $tabla = $this->tabla;
        }
//        $query = $this->construirQuery($tabla, $columnas, $where, $orderBy, $limit, $offset);
//        $this->query($query);
        $this->from($tabla);
        $limit ? $this->limit($limit) : null;
        $offset ? $this->offset($offset) : null;
        return $this->getResult($json, $utf8);
    }

    /**
     * Hace una consulta a la base de datos y el resultado lo devuelve en forma
     * de tabla con sus etiquetas html y class "table".
     * @param string $tabla Nombre de la Tabla.
     * @param string $limit Número de resultados que se quieren obtener.
     * @param string $offset Posición desde el que se quieren obtener los resultados.
     * @param boolean $utf8 Si es true se mostrarán los campos en formato utf8, si
     * no se mostrarán tal cual.
     * @return string Devuelve un string con las etiquetas html de un table.
     */
    public function getTable($tabla, $limit = 0, $offset = 0, $uft8 = false) {

        if (is_array($tabla)) {
            $params = $tabla;
            $utf8 = isset($params["utf8"]) ? $params["utf8"] : $utf8;
            $limit = isset($params["limit"]) ? $params["limit"] : $limit;
            $offset = isset($params["offset"]) ? $params["offset"] : $offset;
            $columnas = "*";
            $tabla = $this->tabla;
        }

        if (!$tabla) {
            $tabla = $this->tabla;
        }

        $this->from($tabla);
        $limit ? $this->limit($limit) : null;
        $offset ? $this->offset($offset) : null;
        $lista = $this->getResult(false, $utf8);

        $tabla = "<table class='table table-striped table-hover'>";
        $tabla .= "<thead><tr>";
        if ($lista) {
            foreach ($lista[0] as $columna => $valor) {
                if ($columna != "_id") {
                    $tabla .= "<th>" . $columna . "</th>";
                }
            }
        }
        $tabla .= "</thead></tr>";
        $tabla .= "<tbody>";
        foreach ($lista as $fila) {
            $tabla .= "<tr id='" . $fila["_id"] . "'>";
            foreach ($fila as $columna => $campo) {
                if ($columna != "_id") {
                    $tabla .= "<td>$campo</td>";
                }
            }
            $tabla .= "</tr>";
        }
        $tabla .= "</tbody>";
        $tabla .= "</table>";

        return $tabla;
    }

    public function getAll() {
        echo $this->get($this->tabla);
    }

//    public function getById(Request $request) {
//        $id = $request["id"];
//        echo $this->get($this->tabla, "*", "id = " + $id);
//    }

    public function getById($id, $tabla = "") {
//        $id = $request["id"];
//        echo $this->get($this->tabla, "*", "id = " + $id);
        if ($tabla) {
            return $this->from($tabla)->where(array("id" => $id))->getSingleResult();
        } else {
            return $this->from($this->tabla)->where(array("id" => $id))->getSingleResult();
        }
    }

    public function getResultados() {
        echo $this->numTotalRegistros($this->tabla);
    }

    public function getPaginas(Request $request, $tabla = "") {

        $limit = $request->get("limit") ? $request->get("limit") : 1;
        if ($tabla) {
            $paginas = ceil($this->numTotalRegistros($tabla) / $limit);
        } else {
            if ($request->get("tabla")) {
                $paginas = ceil($this->numTotalRegistros($request->get("tabla")) / $limit);
            } else {
                $paginas = ceil($this->numTotalRegistros() / $limit);
            }
        }
        echo $paginas;
    }

}
