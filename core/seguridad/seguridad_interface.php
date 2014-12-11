<?php
namespace core\seguridad;

/**
 * Description of seguridad_interface
 *
 * @author Chema
 */
interface seguridad_interface {
    
    public function iniciarSesion($usuario);
    
    /**
     * Recoge los datos que se han recibido del formulario por post. Estos datos tienen como nombre: "usuario" y "password". 
     * @return array Devuelve un array con el resultado de la comprobacion y si se ha logeado con éxito se redirigirá al index.php que está fuera de 
     * la carpeta ws. Si no ha tenido éxito el resultado será un array de la forma {"resultado" => "KO", "mensaje"=>"..."}.
     */
    public function comprobarLogin();
    
    /**
     * Comprueba si el usuario y la contraseña son correctos y si lo son, se inicia la sesión.
     * @param String $usuario
     * @param String $password
     * @return array Se devuelve un array con el resultado de la operación. Tendrá la forma: 
     * {"resultado"=>"OK","mensaje"=>"Autenticado"} en caso de éxito o 
     * {"resultado"=>"KO","mensaje"=>"El usuario o el password es incorrecto."} en caso de fracaso.
     */
    public function login($usuario, $password);
    
    /**
     * Se destruye la sesión.
     */
    public function logout();
    
    /**
     * Devuelve un boolean indicando si hay una sesión iniciada o no.
     * @return boolean Indica si la sesión está iniciada o no. 
     */
    public function isAutenticado();
    
    /**
     * Devuelve un boolean indicando si el tiempo de sesion ha expirado o no.
     * @return boolean Indica si la sesión ha expirado. 
     */
    public function sesionExpirada();
    
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
    public function getTiemposSesion();
    
    /**
     * Devuelve una cadena encriptada con el método indicado en $hash.
     * @param String $password Cadena que se quiere encriptar.
     * @param String $hash Método de encriptación.
     * @return String La cadena encriptada.
     */
    public function encriptar($password, $hash);
    
    /**
     * Detiene la ejecución del script donde esté si la sesión no está iniciada. De esta forma solo se podrá ejecutar el contenido del
     * script si la sesión está iniciada.
     */
    public static function blindar();
    
}
