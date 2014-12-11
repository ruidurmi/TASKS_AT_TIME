<?php
namespace core;

class BD {

    private $conexion = null;
    private $host = "";
    private $user = "";
    private $pass = "";
    private $dataBase = "";
    private $resultado = null;
    protected $tabla = "";
    private $pagina = 1;
    private $numResultados = 0;
    private $columnas;
    private $from;
    private $alias;
    private $join = array();
    private $on = array();
    private $where = array();
    private $or_where = array();
    private $like = array();
    private $or_like = array();
    private $orderBy = array();
    private $limit;
    private $offset;
    private $query;

    public function __construct($host = "", $user = "", $pass = "", $dataBase = "") {
        if (!$host) {
            $host = $this->host;
            $user = $this->user;
            $pass = $this->pass;
            $dataBase = $this->dataBase;
        } else {
            $this->host = $host;
            $this->user = $user;
            $this->pass = $pass;
            $this->dataBase = $dataBase;
        }
        $this->conectar($host, $user, $pass, $dataBase);
    }

    public function conectar($host, $user, $pass, $dataBase) {
        $this->conexion = new \mysqli($host, $user, $pass, $dataBase);
        $this->conexion->set_charset("uft8");
        if ($this->conexion->connect_errno) {
            die("Error: " . $this->conexion->connect_error);
        }
    }

    public function query($query = "", $limit = null, $offset = null) {

        if (!$query) {
            return $this->query;
        } else {
            $this->query = $query;
        }

        if (!$limit) {
            $resultado = $this->conexion->query($query);
        } else {
            $resultado = $this->conexion->query($query . " limit " . $offset . "," . $limit);
        }
//        $resultado = new mysqli_result();
        $this->resultado = $resultado;
//        if ($resultado) {
//            $this->numResultados = $resultado->num_rows;
//        }

        return $resultado;
    }

    public function insert($tabla, $campos = array()) {

        $query = "insert into $tabla values (0,";
        foreach ($campos as $valor) {
            $query .= "'" . $this->conexion->escape_string($valor) . "', ";
        }
        $query = substr($query, 0, strlen($query) - 2);
        $query .= ")";

        $this->query = $query;
//        return $this->conexion->query($query);
        $resultado = $this->conexion->query($query);
        if ($resultado) {
            return $this->conexion->insert_id;
        } else {
            echo false;
        }
    }

    public function update($tabla, $campos = array(), $where = "") {

        $query = "update $tabla set ";
        foreach ($campos as $nombre => $valor) {
            $query .= "$nombre = '" . $this->conexion->escape_string($valor) . "', ";
        }
        $query = substr($query, 0, strlen($query) - 2);
        $query .= " where " . $where;

        $this->query = $query;
        return $this->conexion->query($query);
    }

    public function delete($tabla, $where = "") {
        $query = "delete from $tabla";
        if ($where) {
            $query .= " where $where";
        }
        $this->query = $query;
//        echo $query;
        return $this->conexion->query($query);
    }

    /**
     * Devuelve un array con los resultados.
     * @param boolean $json
     * @param boolean $utf8
     * @return json|array
     */
    public function getResult($json = false, $utf8 = false) {
        $query = $this->obtenerQuery();
        $this->query($query);
        $this->vaciarParametros();
        return $this->procesar($json, $utf8);
    }

    /**
     * Devuelve un unico resultado.
     * @param boolean $json
     * @param boolean $utf8
     * @return json|array
     */
    public function getSingleResult($json = false, $utf8 = false) {
        $query = $this->obtenerQuery();
        $this->query($query);
        $this->vaciarParametros();
        $result = $this->procesar($json, $utf8);
        if ($result) {
            return array_pop($result);
        } else {
            return null;
        }
    }

    /**
     * Devuelve un array con los datos de la última consulta realizada o un json.
     * @param boolean $json Si es true el resultado lo devolverá en formato json. 
     * Si es false lo dará como un array.
     * @param boolean $utf8 Si está a true codifica los campos en formato utf8.
     * @return json|array
     */
    private function procesar($json = false, $utf8 = false) {

        if (!$this->resultado) {
            return null;
        }

        $lista = array();
        while ($fila = $this->resultado->fetch_object()) {

            $arr_fila = array();
            foreach ($fila as $nCampo => $campo) {
                if ($utf8) {
                    $arr_fila[$nCampo] = utf8_encode($campo);
                } else {
                    $arr_fila[$nCampo] = $campo;
                }
            }

            array_push($lista, $arr_fila);
        }

        if ($json) {
            return json_encode($lista);
        } else {
            return $lista;
        }
    }

    protected function obtenerQuery() {

        $query = "SELECT ";

        if ($this->columnas) {
            if (is_array($this->columnas)) {
                foreach ($this->columnas as $columna => $nombre) {
                    $query .= "$columna as '$nombre', ";
                }
                $query = substr($query, 0, strlen($query) - 2);
            } else {
                $query .= $this->columnas;
            }
        } else {
            $query .= "*";
        }

        if ($this->from) {
            $query .= " FROM " . $this->from;
        } else {
            $query .= " FROM " . $this->tabla;
        }

        if ($this->alias) {
            $query .= " $this->alias";
        }

        if ($this->join) {
            foreach ($this->join as $indice => $join) {
                $query .= " LEFT JOIN " . $join . " ON " . $this->on[$indice];
            }
        }

        if ($this->where) {
            $query .= " WHERE ";
            if (is_array($this->where)) {
                foreach ($this->where as $indice => $condicion) {
                    if (is_array($condicion)) {
                        foreach ($condicion as $columna => $valor) {
                            $query .= "$columna = '$valor' AND ";
                        }
                    } else {
                        $query .= "$condicion AND ";
                    }
                }
                $query = substr($query, 0, strlen($query) - 5);
            } else {
                $query .= $this->where;
            }
        }

        if ($this->or_where) {
            if (!$this->where) {
                $query .= " WHERE ";
            }else{
                $query .= " OR ";
            }
            if (is_array($this->or_where)) {
                foreach ($this->or_where as $indice => $condicion) {
                    if (is_array($condicion)) {
                        foreach ($condicion as $columna => $valor) {
                            $query .= "$columna = '$valor' OR ";
                        }
                    } else {
                        $query .= "$condicion OR ";
                    }
                }
                $query = substr($query, 0, strlen($query) - 4);
            } else {
                $query .= $this->where;
            }
        }

        if ($this->like) {
            if (!$this->where) {
                $query .= " WHERE ";
            }else {
                $query .= " AND ";
            }
            if (is_array($this->like)) {
                foreach ($this->like as $indice => $condicion) {
                    if (is_array($condicion)) {
                        foreach ($condicion as $columna => $valor) {
                            $query .= "$columna LIKE '$valor' AND ";
                        }
                    } else {
                        $query .= "$condicion AND ";
                    }
                }
                $query = substr($query, 0, strlen($query) - 5);
            } else {
                $query .= $this->like;
            }
        }
        
        if ($this->or_like) {
            if (!$this->where) {
                $query .= " WHERE ";
            }else{
                $query .= " OR ";
            }
            if (is_array($this->or_like)) {
                foreach ($this->or_like as $indice => $condicion) {
                    if (is_array($condicion)) {
                        foreach ($condicion as $columna => $valor) {
                            $query .= "$columna LIKE '$valor' OR ";
                        }
                    } else {
                        $query .= "$condicion OR ";
                    }
                }
                $query = substr($query, 0, strlen($query) - 4);
            } else {
                $query .= $this->or_like;
            }
        }
        
        if ($this->orderBy) {
            $query .= " order by $this->orderBy ";
        }

        if ($this->limit && !$this->offset) {
            $query .= " limit $this->limit";
        } elseif ($this->limit && $this->offset) {
            $query .= " limit $this->offset, $this->limit";
        }
        return $query;
    }

    public function numResultados() {
        return $this->resultado->num_rows;
    }

    public function numTotalRegistros($tabla = null) {
        if ($tabla) {
            return $this->conexion->query("select * from $tabla")->num_rows;
        } else {
            return $this->conexion->query("select * from $this->tabla")->num_rows;
        }
    }

    public function desconectar() {
        $this->conexion->close();
    }

    public function select($columnas = "") {
        $this->columnas = $columnas;
        return $this;
    }

    public function from($tabla, $alias = "") {
        $this->from = $tabla;
        $this->alias = $alias;
        return $this;
    }

    public function join($tabla, $on) {
        array_push($this->join, $tabla);
        array_push($this->on, $on);
        return $this;
    }

    public function where($clausulas) {
        array_push($this->where, $clausulas);
        return $this;
    }

    public function or_where($clausulas) {
        array_push($this->or_where, $clausulas);
        return $this;
    }

    public function like($clausulas) {
        array_push($this->like, $clausulas);
        return $this;
    }
    public function or_like($clausulas) {
        array_push($this->or_like, $clausulas);
        return $this;
    }

    public function orderBy($orderBy) {
        $this->orderBy = $orderBy;
        return $this;
    }

    public function limit($limit) {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset) {
        $this->offset = $offset;
        return $this;
    }

    private function vaciarParametros() {
        $this->columnas = array();
        $this->where = "";
        $this->like = "";
        $this->orderBy = "";
        $this->limit = "";
        $this->offset = "";
        $this->join = array();
        $this->on = array();
    }

}
