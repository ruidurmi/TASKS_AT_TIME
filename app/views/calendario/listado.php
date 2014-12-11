<table class="tabla alt">
    <thead>
        <tr>
            <th>Id</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Fecha inicio</th>
            <th>Fecha fin</th>
            <th>Id usuario</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ingredientes as $ingrediente): ?>

            <tr>
                <td><a href="<?php echo getUrl("tareas/mostrar/".$ingrediente["id"]); ?>"><?php echo $tarea["id"] ?></a></td>
                <td><?php echo $tarea["nombre"] ?></td>
                <td><?php echo $tarea["descripcion"] ?></td>
                <td><?php echo $tarea["fecha_inicio"] ?></td>
                <td><?php echo $tarea["fecha_fin"] ?></td>
                <td><?php echo $tarea["usuario_id"] ?></td>
                <td><a href="<?php echo getUrl("tareas/editar/".$tarea["id"]); ?>">Editar</a></td>
            </tr>

        <?php endforeach; ?>
    </tbody>
</table>
<br>
<a href="<?php echo getUrl("tareas/anadir") ?>">Añadir nueva tareas</a>
