<?php
namespace core\seguridad;
require_once __DIR__.'/../../app/Config.php';
require_once __DIR__.'/../funcionesGenerales.php';
use app\Config;

//require "core/seguridad/seguridad_interface.php";

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

/**
 * Clase que se encargará de gestionar la sesión de usuario y la seguridad.
 */
//class Seguridad implements seguridad_interface {
class Seguridad {

    private $usuario = "";
    private $password = "";
    private $autenticado = false;
    private $mysqli = null;
    private $tabla = "";
    private $campos = null;
    private static $key = "6|W^Y7Boc*Z7y4iD";
    private static $salt = '$chw$/';

    private static $nombre_sesion = "security_session";
    
    /**
     * El constructor comprueba si está autenticado el usuario y coge las 
     * variables que necesite de config.php.
     * @param boolean $dataBase Si es false la comprobación del usuario y la contraseña se hará desde el archivo config.php.
     * Si es true, lo mirará en la Base de Datos.
     */
    public function __construct($dataBase = false) {

        session_name(self::$nombre_sesion);
        session_start();
        if (isset($_SESSION["autenticado"]) && isset($_SESSION["id"]) && $_SESSION["autenticado"] === self::$key && $_SESSION["id"] === session_id()) {
            $this->autenticado = true;
        } else {
            $this->autenticado = false;
        }

        if ($dataBase && Config::$host && Config::$user && Config::$dataBase) {
            
            $this->mysqli = new \mysqli(Config::$host, Config::$user, Config::$pass, Config::$dataBase);
            $this->tabla = Config::$tabla;
            if (isset(Config::$campos)) {
                $this->campos = Config::$campos;
            }
            
        } else {
            
            $this->usuario = \app\Config::$usuario;
            if (isset(\app\Config::$salt) && \app\Config::$salt) {
                $this->password = \app\Config::$salt . \app\Config::$password;
            } else {
                $this->password = \app\Config::$password;
            }
            
        }
    }

    public function iniciarSesion($usuario) {
        
        $cookieParams = session_get_cookie_params();
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], true, true);
        session_name(self::$nombre_sesion);
        session_start();
        
        $_SESSION["id"] = session_id();
        $_SESSION["autenticado"] = self::$key;
        $_SESSION["usuario"] = $usuario;
        $_SESSION['inicio'] = time();
        
        $this->autenticado = true;
        
    }

    /**
     * Recoge los datos que se han recibido del formulario por post. Estos datos tienen como nombre: "usuario" y "password". 
     * @return array Devuelve un array con el resultado de la comprobacion y si se ha logeado con éxito se redirigirá al index.php que está fuera de 
     * la carpeta ws. Si no ha tenido éxito el resultado será un array de la forma {"resultado" => "KO", "mensaje"=>"..."}.
     */
    public function comprobarLogin() {
        
        $usuario = isset($_POST["usuario"]) ? $_POST["usuario"] : "";
        $password = isset($_POST["password"]) ? $_POST["password"] : "";
//        echo $usuario;
        if ($this->validarTexto($usuario) && $this->validarTexto($password)) {
            
            if ($usuario) {
                $resultado = $this->login($usuario, $password);
            } else {
                $resultado = array("resultado" => "KO", "mensaje" => "");
            }
            
            return $resultado;
            
        } else {
            return array("resultado" => "KO", "mensaje" => "Se han introducido carácteres no válidos.");
        }
        
    }

    /**
     * Comprueba si el usuario y la contraseña son correctos y si lo son, se inicia la sesión.
     * @param String $usuario
     * @param String $password
     * @return array Se devuelve un array con el resultado de la operación. Tendrá la forma: 
     * {"resultado"=>"OK","mensaje"=>"Autenticado"} en caso de éxito o 
     * {"resultado"=>"KO","mensaje"=>"El usuario o el password es incorrecto."} en caso de fracaso.
     */
    public function login($usuario, $password) {

        // Comprobación del usuario y la contraseña desde un archivo config.php
        if ($this->mysqli === null) {
            if ($usuario === $this->usuario) {
                // Se mira si la contraseña está encriptada y se encripta en caso afirmativo.
                $hash = "text/plain";
                if (isset(\app\Config::$encriptacion)) {
                    $hash = \app\Config::$encriptacion;
                }
                $passwordCrypt = $this->encriptar($password, $hash);

                // Se mira si hay un salt y se le aplica a la contraseña encriptada.
                if (isset(\app\Config::$salt) && \app\Config::$salt) {
                    $passwordCrypt = Config::$salt . $passwordCrypt;
                }

                // Se comparan las contraseñas.
                if ($passwordCrypt === $this->password) {
                    // El usuario se ha registrado correctamente. Se inicia la sesión.
                    $this->iniciarSesion($usuario);
                    return array("resultado" => "OK", "mensaje" => "Autenticado");
                } else {
                    // El usuario no se ha registrado correctamente.
                    $this->autenticado = false;
                    return array("resultado" => "KO", "mensaje" => "El password es incorrecto.");
                }
            } else {
                $this->autenticado = false;
                return array("resultado" => "KO", "mensaje" => "El usuario es incorrecto.");
            }
        } else {

            // Comprobación del usuario y la contraseña desde una base de datos.    

            if (!$this->campos) {
                $this->campos = array("usuario", "password");
            }

            // Se prepara la sentencia.
            $sentencia = $this->mysqli->prepare("select * from $this->tabla where " . $this->campos[0] . " = ? and " . $this->campos[1] . " = ?");

            // Se mira si la contraseña está encriptada y la encripta en caso afirmativo.
            $hash = "text/plain";
            if (isset(\app\Config::$encriptacion)) {
                $hash = \app\Config::$encriptacion;
            }
            
            $passwordCrypt = $this->encriptar($password, $hash);
            
            // Se enlazan a la consulta los parametros.
            $sentencia->bind_param("ss", $usuario, $passwordCrypt);
            if ($sentencia->execute()) {
                
                $sentencia->store_result();
                $filas = $sentencia->num_rows;
                $sentencia->fetch();
                $sentencia->close();
                
                if ($filas > 0) {
                    // El usuario se ha registrado con éxito. Se inicia la sesión.
                    $this->iniciarSesion($usuario);
                    return array("resultado" => "OK", "mensaje" => "Autenticado");
                } else {
                    // El usuario no se ha registrado con éxito.
                    $this->autenticado = false;
                    return array("resultado" => "KO", "mensaje" => "El usuario o el password es incorrecto.");
                }
                
            } else {
                return array("resultado" => "KO", "mensaje" => "Error en la consulta.");
            }
        }
    }

    /**
     * Se destruye la sesión.
     */
    public function logout() {
        
        session_unset();
        session_regenerate_id();
        session_destroy();
        
        $this->autenticado = false;
        
    }

    /*
     * Devuelve un boolean indicando si hay una sesión iniciada o no.
     * @return boolean Indica si la sesión está iniciada o no. 
     */

    public function isAutenticado() {
        
        return !$this->sesionExpirada();
    
    }

    /**
     * Devuelve un boolean indicando si el tiempo de sesion ha expirado o no.
     * @return boolean Indica si la sesión ha expirado. 
     */
    public function sesionExpirada() {
    
        if (isset($_SESSION["autenticado"]) && isset($_SESSION["id"]) && $_SESSION["autenticado"] === self::$key && $_SESSION["id"] === session_id()) {
            
            if (\app\Config::$tiempo_sesion > 0) {
                
                $segundos = time();
                $tiempo_transcurrido = $segundos;
                
                if (isset($_SESSION["inicio"])) {
                    $tiempo_maximo = $_SESSION['inicio'] + ( \app\Config::$tiempo_sesion );
                } else {
                    $tiempo_maximo = 0;
                }
                
                if ($tiempo_maximo !== 0 && $tiempo_transcurrido > $tiempo_maximo) {
                    $this->logout();
                    return true;
                } else {
                    if ($_SESSION["usuario"]) {
                        $this->autenticado = true;
                        return false;
                    }
                }
                
            } else {
                
                if ($_SESSION["usuario"]) {
                    $this->autenticado = true;
                    return false;
                }
                
            }
            
        }
        
        $this->autenticado = false;
        return true;
        
    }

    /**
     * Devuelve un array con los tiempos de sesion.
     * @return array El array devuelto contiene la información de los tiempos de sesión.
     * <ul>
     * <li>inicio: Momento en que se ha iniciado la sesión, en timestamp.</li>
     * <li>final: Momento en el que finaliza la sesión, en timestamp.</li>
     * <li>duracion: Duración de la sesión, en segundos.</li>
     * <li>transcurrido: Tiempo que ha transcurrido desde que se inició sesión, en segundos.</li>
     * <li>restante: Tiempo que queda hasta que finalice la sesión, en segundos.</li>
     * </ul>
     */
    public function getTiemposSesion() {
        
        if ($this->autenticado) {
        
            $tiempo_transcurrido = time();
            $inicio = $_SESSION['inicio'];
            $tiempo_maximo = $inicio + ( \app\Config::$tiempo_sesion );

            $tiempos = array(
                "inicio" => $inicio,
                "transcurrido" => ($tiempo_transcurrido - $inicio),
                "restante" => ($tiempo_maximo - $tiempo_transcurrido),
                "final" => $tiempo_maximo,
                "duracion" => \app\Config::$tiempo_sesion
            );
            
            return $tiempos;
            
        } else {
            return null;
        }
        
    }

    /**
     * Devuelve una cadena encriptada con el método indicado en $hash.
     * @param String $password Cadena que se quiere encriptar.
     * @param String $hash Método de encriptación.
     */
    public function encriptar($password, $hash = "text/plain") {
        
        try {
        
            if ($hash === "text/plain") {
                $passwordCrypt = $password;
            } else {
                $passwordCrypt = hash($hash, $password);
            }

            return $passwordCrypt;
            
        } catch (Exception $e) {
            die("Error con la función hash");
        }
        
    }

    private function validarTexto($texto) {
        
        $caractersValidos = "/^[a-z0-9\-\_\.@\(\)\[\]]{0,}$/i";
        return preg_match($caractersValidos, $texto);
        
    }

    /**
     * Detiene la ejecución del script donde esté si la sesión no está iniciada. De esta forma solo se podrá ejecutar el contenido del
     * script si la sesión está iniciada.
     */
    public static function blindar() {
        
        $seguridad = new Seguridad();
        if (!$seguridad->isAutenticado()) {
//            header("Location: ws/seguridad/login.php");
//            exit();
            die("No tienes acceso a este contenido.");
        }
        
    }

}
