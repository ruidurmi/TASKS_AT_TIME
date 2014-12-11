<html>
    <head>
        <title><?php echo isset($titulo) ? $titulo : "Administracion"; ?></title>
        <meta charset="utf-8">




        <script src="<?php echo getUrl("assets/js/jquery-ui-1.11.1.custom/external/jquery/jquery.js") ?>"></script>
        <script src="<?php echo getUrl("assets/js/jquery-ui-1.11.1.custom/jquery-ui.js") ?>"></script>
        <link href="<?php echo getUrl("assets/js/jquery-ui-1.11.1.custom/jquery-ui.cs") ?>s" rel="stylesheet" />

        <?php stylesheets("styles"); ?>
    </head>
    <body>

        <header>
            <div>
                <img class="logo" src="<?php echo getUrl("assets/images/logo.png") ?>">
                <h1 class="nombre">Tasks At Time</h1>
            </div>

            <nav>
                <a id="first" href="<?php echo getUrl("") ?>">Home</a>
                <a href="<?php echo getUrl("calendario") ?>">Calendario</a>
                <a href="<?php echo getUrl("login") ?>" id="last">Login</a>
            </nav>

            <a href="<?php echo getUrl('logout') ?>" class="logout">Logout</a>
        </header>
        <div id="lista"></div>
        <div class="transparente">


            <div class="content">
                <?php echo $content ?>
            </div>

        </div>

        <footer>
            <a href="#">Copyright© Gestión de tareas 2014</a>
        </footer>
        <script>
            $(function () {
                $("#draggable").draggable();
            });
        </script>

        <script>
            $(function () {
                $(".draggable").draggable({
                    start: function () {
                        $(this).height(12).width(60); //drag dimensions
                    },
                    stop: function () {
                        $(this).height(12).width(60); //original icon size
                    }
                });
                $(".droppable").droppable({
                    drop: function (event, ui) {
                        $(this).addClass("ui-state-highlight");
                        alert("Pesaaaaadaaaaaa y locaaaaa , esta es la fecha: " + $(this).data("fecha"));


                        var draggableId = ui.draggable.attr("id");
                        var droppableId = $(this).attr("id");                      
                        console.log(draggableId);
                        console.log(droppableId);
                        var obj = {"nombre":"+$draggableId.attr('data-nombre')+", "descripcion":"+$draggableId.attr('data-descripcion')+", "fechainicio":"+$draggableId.attr('data-fechainicio')+", "fechafin":"+$draggableId.attr('data-fechafin')+"};
                        $.ajax({
//                        Url del php o aspx.
                            url: "<?php echo getUrl("calendario/insertarTarea") ?>",
                            // Metodo post o get
                            method: "post",
                            // Tipo de los datos que se reciben: json, text, html, xml
                            dataType: "json",
                            // Los datos que se quieren enviar por post. Puede ser $("formu").serialize();
                            data: obj,
                            // Evento que salta cuando se han recibido los datos con éxito.
                            success: function (datos) {

                                // Datos será un array de forma ["Audi","BMW",...]
                                //            var lista = $("#lista");
                                //            for(var i = 0; i < datos.length; i++){
                                //                lista.append("<li>"+datos[i]+"</li>");
                                //            }
                                alert("Hola");

                            },
                            // Evento que salta cuando ha habido algún error con el servidor.
                            error: function (e) {
                                console.log("Error");
                            }
                        });
                                                
                    }
                });
            });</script>

        <script type="text/javascript">
            $(document).ready(function () {
                //            $("#siguiente").click(function() {
                //               if ($("#calendario").is(":visible")) {
                //                   console.log("a");
                //                  $("#calendario").css("display", "none");
                //
                //            
                //               else {
                //                   console.log("b");
                //                   $("#calendario2").css("display", "block");
                //               }
                //                if ($("#calendario2").is(":visible")) {
                //                  $("#calendario2").css("display", "none");
                //                  
                //               }
                //            });

                $("#siguiente").click(function () {

                    if ($("#Calendario2").is(":hidden")) {
                        $("#Calendario2").css("display", "inline-block");

                        $("#anterior").css("display", "inline-block");
                    }
                    else {
                        $("#Calendario2").slideUp("slow");
                    }

                    if ($("#Calendario").is(":visible")) {
                        $("#Calendario").css("display", "none");
                        $("#siguiente").css("display", "none");

                    }
                });
                $("#anterior").click(function () {

                    if ($("#Calendario").is(":hidden")) {
                        $("#Calendario").css("display", "inline-block");
                        $("#Calendario").css("margin-top", "15px");

                    }
                    else {
                        $("#Calendario").slideUp("slow");
                    }

                    if ($("#Calendario2").is(":visible")) {
                        $("#Calendario2").css("display", "none");
                        $("#anterior").css("display", "none");
                        $("#siguiente").css("display", "inline-block");

                    }
                });

            });



        </script>   
    </body>
</html>