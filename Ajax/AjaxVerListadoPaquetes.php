<?php

include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Render                    = new Visual();
$Paquete                   = new Servicios();
$municipio=0;
if(isset($_POST['municipio']))
{
    $municipio                 = $_POST['municipio'];
}

$FechaInicion              = $_POST['FechaInicion'];
$FechaFin                  = $_POST['FechaFin'];
$n_pagina                  = $_POST['n_pagina'];
$cantidad_registros_pagina = $_POST['cantidad_registros_pagina'];
$Datos                     = $Paquete->BuscarPaquetes($municipio, $FechaInicion, $FechaFin, $n_pagina, $cantidad_registros_pagina);
$Tabla= $Render->Tabla($Datos,'',array('#','Nombre','Valor','Fecha inicio','Imagen'),'table','',true);
echo $Render->Paginar($Tabla);