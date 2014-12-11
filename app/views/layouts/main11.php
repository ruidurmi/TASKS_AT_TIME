<html>
    <head>
        <title><?php echo isset($titulo) ? $titulo : "Administracion"; ?></title>
        <meta charset="utf-8">

        <?php stylesheets("theme"); ?>
        <?php stylesheets("style"); ?>
        <?php javascripts("jquery-1.11.0"); ?>
        <?php javascripts("main"); ?>
        
    </head>
    <body>

        <div class="navegador">
            <div class="nav-content">
                <ul>
                    <li class="activo"><a href="<?php echo getUrl("ingredientes/listado") ?>">Ingredientes</a></li>
                    <li><a href="<?php echo getUrl("perfumes/") ?>">Perfumes</a></li>
                    <li class="right"><a href="<?php echo getUrl("user/logout"); ?>">Logout</a></li>
                </ul>
            </div>
        </div>

        <div class="header">
            <h1>Plantilla principal</h1>
        </div>

        <div class="cuerpo">

            <div class="content">
                <?php echo $content ?>
            </div>

        </div>
    </body>
</html>