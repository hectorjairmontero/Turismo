<?php

include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Render    = new Visual();
$Paquete   = new Servicios();
$municipio = 0;
if (isset($_POST['municipio']))
{
    $municipio = $_POST['municipio'];
}

$FechaInicion              = $_POST['FechaInicion'];
$FechaFin                  = $_POST['FechaFin'];
$n_pagina                  = $_POST['n_pagina'];
$cantidad_registros_pagina = $_POST['cantidad_registros_pagina'];
$Datos                     = $Paquete->BuscarPaquetes($municipio, $FechaInicion, $FechaFin, $n_pagina, $cantidad_registros_pagina);
$cantidad                  = $Datos['Cantidad'] / $cantidad_registros_pagina;
$col                       = 2;
$count                     = count($Datos['Datos']);
$Res                       = $Datos['Datos'];
if ($count > 0)
{
    for ($i = 0; $i < ($count); $i++)
    {
        $value      = $Res[$i];
        $id_paquete = $value['id_paquete'];
        $Nombre     = $value['Nombre'];
        $Valor      = $value['Valor'];
        $Fecha      = $value['Fecha_inicio'];
        $Image      = $value['foto'];
        $Decripcion = $value['Descripcion'];
        $Datos      = array('Nombre' => $Nombre, 'Valor' => $Valor, 'Fecha' => $Fecha, 'Image' => $Image, 'Descripcion' => $Decripcion);
        $html       = '<div class="col-lg-' . $col . '">'
                . '<a href="javascript:VerModal(' . $id_paquete . ');">
        <div class="panel panel-primary" title="' . $Decripcion . '">
        <div class="panel-heading">
         <h3 class="panel-title">' . strtoupper($Nombre) . '</h3></div>
                <div class="panel-body">
                    ' . $Image . '
                      PRECIO: $' . number_format($Valor, 2, ',', '.') . ' 
                </div>
            </div></a>
            </div>';
        if($i%(12/$col)==0)
        {echo '<div class="row">';}
        echo $html;
        if($i%(12/$col)==((12/$col)-1))
        {echo '</div>';}

        
    }
}
echo '<div class="row">';
echo $Render->Paginar('', $n_pagina, $cantidad, 'VerListado');
echo '</div>';
