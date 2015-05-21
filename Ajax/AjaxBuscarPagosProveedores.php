<?php

include_once '../Controller/Reserva.php';
include_once '../Controller/Visual.php';
$Render      = new Visual();
$Pagos       = new Reserva();
$FechaInicio = $_POST['FechaInicio'];
$FechaFin    = $_POST['FechaFin'];
$Datos       = $Pagos->VerReservasPagasProveedores($FechaInicio, $FechaFin);
$Datos=$Render->FunctionTable($Datos, '0', 'imprimir', 'images/imp.gif');
$Datos=$Render->FunctionTable($Datos, '1', 'Detalle', 'images/lapiz.png');
echo $Render->Tabla($Datos,'',array('#','Imprimir','Ver','Proveedor','valor','Tipo'),'table table-hover','',1);