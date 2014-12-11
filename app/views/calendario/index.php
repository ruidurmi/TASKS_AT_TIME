
<div class="contenedor_tareas">
    <div id="t1" class="ui-widget-content draggable">
        <p class="tarea">Tarea 1</p>
    </div>
    <div id="t2" class="ui-widget-content draggable">
        <p class="tarea">Tarea 2</p>
    </div>
    <div id="t3" class="ui-widget-content draggable">
        <p class="tarea">Tarea 3</p>
    </div>


</div>
<div class="contenedor_tabla">
    <button id="anterior">Anterior</button><button id="siguiente">Siguiente</button>
    <?php
    $tabla = '';
    $tabla.="<table id='Calendario' border='1'>";
    $tabla.="    <tr>";
    $tabla.="        <th class='encabezadoHora'>HORA</th>";
    $tabla.="        <th class='encabezado'>LUNES 15</th>";
    $tabla.="        <th class='encabezado'>MARTES 16</th>";
    $tabla.="        <th class='encabezado' style='width: 14%'>MIÉRCOLES 17</th>";
    $tabla.="        <th class='encabezado'>JUEVES 18</th>";
    $tabla.="        <th class='encabezado'>VIERNES 19</th>";
    $tabla.="        <th class='encabezado'>SÁBADO 20</th>";
    $tabla.="        <th class='encabezado last'>DOMINGO 21</th>";
    $tabla.="    </tr>";
    for ($i = 0; $i < 24; $i++) {
        $tabla.="    <tr>";
        $tabla.="       <td class='columnaHora'>" . $i . "</td>";
        for ($j = 15; $j < 22; $j++) {
            $fecha = "2014-12-" . (strlen($j) < 2 ? "0" . $j : $j) . " " . (strlen($i) < 2 ? "0" . $i : $i ) . ":00:00";
            $tabla.=" <td id='".$fecha."' data-fecha='" . $fecha . "' class='columna ui-widget-header droppable'>";
            for ($k = 0; $k < sizeof($tareas); $k++) {
                if ($tareas[$k]['fecha_inicio'] == $fecha) {
                    $tabla.="<div id='t" . $k . "' class='ui-widget-content draggable' data-nombre='".$tareas[$k]['nombre']."' data-descripcion='".$tareas[$k]['descripcion']."' data-fechainicio='".$tareas[$k]['fecha_inicio']."' data-fechafin='".$tareas[$k]['fecha_fin']."'>";
                    $tabla.="<p class='tarea'>" . $tareas[$k]['descripcion'] . "</p>";
                    $tabla.="</div>";
                }
                
            }
            $tabla.="</td>";
        }
        $tabla.="    </tr>";
//            $tabla.=" <td data-fecha='" . $fecha . "' class='columna ui-widget-header droppable'></td>";
    }


    $tabla.="</table>";

echo $tabla;
    
    ?>
     <?php
     
      $tabla2 = '';
    $tabla2.="<table id='Calendario2' border='1'>";
    $tabla2.="    <tr>";
    $tabla2.="        <th class='encabezadoHora'>HORA</th>";
    $tabla2.="        <th class='encabezado'>LUNES 22</th>";
    $tabla2.="        <th class='encabezado'>MARTES 23</th>";
    $tabla2.="        <th class='encabezado' style='width: 14%'>MIÉRCOLES 24</th>";
    $tabla2.="        <th class='encabezado'>JUEVES 25</th>";
    $tabla2.="        <th class='encabezado'>VIERNES 26</th>";
    $tabla2.="        <th class='encabezado'>SÁBADO 37</th>";
    $tabla2.="        <th class='encabezado last'>DOMINGO 38</th>";
    $tabla2.="    </tr>";
    for ($i = 0; $i < 24; $i++) {
        $tabla2.="    <tr>";
        $tabla2.="       <td class='columnaHora'>" . $i . "</td>";
        for ($j = 22; $j < 29; $j++) {
            $fecha = "2014-12-" . (strlen($j) < 2 ? "0" . $j : $j) . " " . (strlen($i) < 2 ? "0" . $i : $i ) . ":00:00";
            $tabla2.=" <td id='".$fecha."'  data-fecha='" . $fecha . "' class='columna ui-widget-header droppable'>";
            for ($k = 0; $k < sizeof($tareas); $k++) {
                if ($tareas[$k]['fecha_inicio'] == $fecha) {
                    $tabla2.="<div id='t" . $k . "' class='ui-widget-content draggable' data-nombre='".$tareas[$k]['nombre']."' data-descripcion='".$tareas[$k]['descripcion']."' data-fechainicio='".$tareas[$k]['fecha_inicio']."' data-fechafin='".$tareas[$k]['fecha_fin']."'>";
                    $tabla2.="<p class='tarea'>" . $tareas[$k]['descripcion'] . "</p>";
                    $tabla2.="</div>";
                }
                
            }
            $tabla2.="</td>";
        }
        $tabla2.="    </tr>";
//            $tabla.=" <td data-fecha='" . $fecha . "' class='columna ui-widget-header droppable'></td>";
    }


    $tabla2.="</table>";

echo $tabla2;
     

    ?>

</div>
<?php



