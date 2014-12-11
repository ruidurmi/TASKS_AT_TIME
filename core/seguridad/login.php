<?php
//namespace core\seguridad;
require_once __DIR__ . '/seguridad.php';
$seguridad = new \core\seguridad\Seguridad();
//$seguridad = new Seguridad(true);
$resultado = $seguridad->comprobarLogin();
if($resultado){
    if($resultado["resultado"] == "OK"){
        header("Location: ".  getUrl(""));
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <style type="text/css">
            body{
                margin: 0px;
                padding: 0px;
                background-color: rgb(222, 222, 222);
            }
            .divLogin {
                border: solid 1px rgb(224, 224, 224);
                border-radius: 10px;
                padding: 20px;
                position: absolute;
                top: 100px;
                margin-left: 50%;
                left: -200px;
                width: 400px;
                /* height: 200px; */
                box-shadow: 2px 5px 6px #777;
                background-color: white;
            }
            .divLogin h1 {
                font-family: arial;
            }
            .formInput {
                margin: 15px 0px;}
            .formInput label {
                font-family: arial;
                font-size: 18px;
            }
            .formInput input {
                width: 96%;
                height: 30px;
                border-radius: 5px;
                border: solid 1px #C6C6C6;
                padding: 5px;
                box-shadow: 0px 2px 8px -2px #ccc inset;
                font-size: 16px;
            }
            .formInput .btn.btnSubmit {}
            .btn {
                border: solid 1px !important;
                width: auto !important;
                height: auto !important;
                padding: 10px 20px !important;
                box-shadow: 1px 1px 1px #777 !important;
            }
            .btn:hover {
                cursor: pointer;
                background-color: #C4C4C4;
                box-shadow: 2px 2px 2px #777 !important;
            }
            .mensaje {
                background-color: rgb(255, 199, 199);
                border: solid 1px rgb(176, 35, 35);
                border-radius: 5px;
                padding: 0px 10px;
                color: rgb(176, 35, 35);
                font-family: arial;
            }
            .mensaje p {}
        </style>
    </head>
    <body>
        <div class="divLogin">
            <h1>Login</h1>
            <?php if ($resultado["resultado"] === "KO" && $resultado["mensaje"]): ?>
                <div class="mensaje">
                    <p><?php echo $resultado["mensaje"] ?></p>
                </div>
            <?php endif; ?>
            <form method="post" action="login.php">
                <div class="formInput">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" autofocus="autofocus">
                </div>
                <div class="formInput">
                    <label>Password:</label>
                    <input type="password" name="password">
                </div>
                <div class="formInput">
                    <input type="submit" class="btn btnSubmit">
                </div>
            </form>
        </div>

    </body>
</html>
