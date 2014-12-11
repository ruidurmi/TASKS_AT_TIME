<ul class="lista">
    <li>Id: <?php echo $ingrediente["id"]; ?></li>
    <li>Nombre esp: <?php echo $ingrediente["nombre_esp"]; ?></li>
    <li>Nombre cat: <?php echo $ingrediente["nombre_cat"]; ?></li>
    <li>Nombre eng: <?php echo $ingrediente["nombre_eng"]; ?></li>
    <li>Familia: <?php echo $ingrediente["familia"]; ?></li>
</ul>
<a href="<?php echo getUrl("ingredientes/listado") ?>">Volver al listado</a>
&nbsp;
<a href="<?php echo getUrl("ingredientes/editar/".$ingrediente["id"]) ?>">Modificar</a>