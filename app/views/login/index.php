<div class="content">
    <div class="caja_login">
        <div class="titulo_b" style="text-align: center;">
            <h1>BIENVENIDO</h1>
        </div>
        <div class="caja_campos">
            <form method="post" action="<?php echo getUrl("login"); ?>" style="text-align: center;">
                <span class="lb_login">Nombre de usuario:</span><br/>
                <!--<input name="txtLogin" maxlength="50" id="txtLogin" class="usuario" type="text" placeholder="usuario" /><br/>-->
                <input name="usuario" maxlength="50" id="txtLogin" class="usuario" type="text" placeholder="usuario" /><br/>



                <span class="lb_login">Contraseña:</span><br/>
                <!--<input name="txtPassword" type="password" maxlength="50" id="txtPassword" class="contrasenia" type="password" placeholder="contraseña" /><br/>-->
                <input name="password" type="password" maxlength="50" id="txtPassword" class="contrasenia" type="password" placeholder="contraseña" /><br/>

                <div class="">
                    <input type="submit" name="enviar" id="bt_enviar" class="enviar" value="ENVIAR">

                </div>
            </form>
        </div>

    </div>
</div>