<?php

namespace app;

/**
 * Description of Config
 *
 * @author Chema
 */
class Config {

    // Configuracion de la base de datos.

    public static $host = "localhost";
    public static $user = "root";
    public static $pass = "";
    public static $dataBase = "tasks_at_time";
    // Configuracion para el acceso con usuario y contraseña.
    // Si no se necesita loguearse entonces se puede poner:
//    public static $usuario = "";
//    public static $password = "";
    public static $usuario = "admin";
    public static $password = "admin";
//    public static $salt = 'chwf';
    // Tiempo que durará la sesión. En segundos.
    public static $tiempo_sesion = 0; // Sin limite.
//    public static $tiempo_sesion = 1200; // 20 minutos.
//    public static $tiempo_sesion = 2400; // 40 minutos.
//    public static $tiempo_sesion = 3600; // 1 hora.
//    public static $tiempo_sesion = 7200; // 2 horas.
//        public static $host = "genericwebdomain.com";
//    public static $host = "localhost";
//    public static $user = "root";
//    public static $pass = "wGMDuAR9";
//    public static $database = "tasks_at_time";

    public static $tabla = "usuarios";
    public static $campos = array("nombre", "contrasenia");
//    public static $encriptacion = "md5";
//    public static $encriptacion = "sha1";
//    public static $encriptacion = "text/plain"; 
    // Configuración del ruteo.
    public static $rutas = array(
//        "controlador/metodo/parametros" => "controlador/metodo",
//        "controlador/metodo/{:num}/{:text}/{:any}" => "controlador/metodo",
        "" => "home/index",
        "ingredientes/" => "ingredientes/index",
        "ingredientes/index" => "ingredientes/index",
        "ingredientes/listado" => "ingredientes/listado",
        "ingredientes/mostrar/{:num}" => "ingredientes/mostrar/{id}",
        "ingredientes/mostrars/{:num}/{:num}" => "ingredientes/listar/{id1}/{id2}",
        "ingredientes/anadir" => "ingredientes/anadir",
        "ingredientes/editar/{:text}" => "ingredientes/editar/{id}",
        "ingredientes/eliminar/{:any}" => "ingredientes/eliminar/{id}",
        "perfumes/" => "perfumes/listado",
        "login" => "login/index",
        "user/logout" => "user/logout",
        "user/login" => "user/login",
//        "home" => "home/index",
        "calendario" => "calendario/tareas",
         "logout" => "login/logout",
        "tareas" => "calendario/tareas",
        "tareas/insertar" => "calendario/insertarTarea"
    );

}
