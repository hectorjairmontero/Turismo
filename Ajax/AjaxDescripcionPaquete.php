<?php

if (isset($_POST['Paquetes'])&&$_POST['Paquetes']!='0')
{
    include_once '../Controller/Servicios.php';
    include_once '../Controller/Visual.php';
    $Descripcion  = new Servicios();
    $Render       = new Visual();
    $id_paquete   = $_POST['Paquetes'];
    $Datos        = $Descripcion->VerDescripcionPaquete($id_paquete);
    $Nombre       = $Datos['Nombre'];
    $Valor        = $Datos['Valor'];
    $Fecha_inicio = $Datos['Fecha_inicio'];
    $Fecha_fin    = $Datos['Fecha_fin'];
    $Descripcion  = $Datos['Descripcion'];
    echo '<h3>'.$Nombre.'</h3>';
    echo "<h5>Valor: $".number_format($Valor, 0, ',', '.')."</h5>";
    echo "<h5>Descripcion:$Descripcion</h5>";
}
else
{
    echo null;
}