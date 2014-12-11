<?php
namespace core;

require_once 'app/Config.php';
//require_once 'BD.php';

/**
 * Description of Usuarios
 *
 * @author Chema
 */
class Users {

    public function estaAutenticado() {
        @session_start();
        if (isset($_SESSION["usuario"])) {
            if (Config::$tiempo_sesion > 0) {
                $segundos = time();
                $tiempo_transcurrido = $segundos;
                if (isset($_SESSION["inicio"])) {
                    $tiempo_maximo = $_SESSION['inicio'] + ( Config::$tiempo_sesion );
                } else {
                    $tiempo_maximo = 0;
                }
                if ($tiempo_maximo !== 0 && $tiempo_transcurrido > $tiempo_maximo) {
                    session_unset();
                    session_destroy();
                    return false;
                } else {
                    if ($_SESSION["usuario"]) {
                        return true;
                    }
                }
            } else {
                if ($_SESSION["usuario"]) {
                    return true;
                }
            }
        }
        return false;
    }

    public function login($user, $password) {
        if ($user == Config::$usuario && $password == Config::$password) {
            session_start();
            $_SESSION["usuario"] = $user;
            $_SESSION['inicio'] = time();
            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        session_start();
        session_regenerate_id();
        session_unset();
        session_destroy();
    }

//    public function 

    public function setData($data = array()) {

        if (!is_array($data)) {
            return null;
        }

        session_start();
        foreach ($data as $key => $value) {
            $_SESSION[$key] = $value;
        }
    }

    public function getData($data = "") {
        session_start();
        if (!$data) {
            return $_SESSION;
        } else {
            return isset($_SESSION[$data]) ? $_SESSION[$data] : "";
        }
    }

}
