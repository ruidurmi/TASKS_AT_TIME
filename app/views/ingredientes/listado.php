<table class="tabla alt">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre esp</th>
            <th>Nombre eng</th>
            <th>Nombre cat</th>
            <th>Familia</th>
            <th>Opciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ingredientes as $ingrediente): ?>

            <tr>
                <td><a href="<?php echo getUrl("ingredientes/mostrar/".$ingrediente["id"]); ?>"><?php echo $ingrediente["id"] ?></a></td>
                <td><?php echo $ingrediente["nombre_esp"] ?></td>
                <td><?php echo $ingrediente["nombre_eng"] ?></td>
                <td><?php echo $ingrediente["nombre_cat"] ?></td>
                <td><?php echo $ingrediente["familia"] ?></td>
                <td><a href="<?php echo getUrl("ingredientes/editar/".$ingrediente["id"]); ?>">Editar</a></td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<br>
<a href="<?php echo getUrl("ingredientes/anadir") ?>">Añadir nuevo ingrediente</a>
