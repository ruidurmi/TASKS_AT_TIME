<ul class="lista">
    <li>Id: <?php echo $tarea["id"]; ?></li>
    <li>Nombre esp: <?php echo $tarea["nombre"]; ?></li>
    <li>Nombre cat: <?php echo $tarea["descripcion"]; ?></li>
    <li>Nombre eng: <?php echo $tarea["fecha_inicio"]; ?></li>
    <li>Familia: <?php echo $tarea["fecha_fin"]; ?></li>
    <li>Familia: <?php echo $tarea["usuario_id"]; ?></li>
</ul>
<a href="<?php echo getUrl("tareas/listado") ?>">Volver al listado</a>
&nbsp;
<a href="<?php echo getUrl("tareas/editar/".$tarea["id"]) ?>">Modificar</a>