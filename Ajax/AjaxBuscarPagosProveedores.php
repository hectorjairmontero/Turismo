<?php

include_once '../Controller/Reserva.php';
include_once '../Controller/Visual.php';
$Render      = new Visual();
$Pagos       = new Reserva();
extract($_POST);
if($id_proveedores==0)
{$id_proveedores='';}
$Datos       = $Pagos->VerReservasPagasProveedores($FechaInicio, $FechaFin,$id_proveedores);
$V=0;
for($i=0;$i<count($Datos);$i++)
{
    $V=$V+$Datos[$i]['valor'];
}
echo '<center><h1>Total: $'.$V.'</h1></center>';
$Datos=$Render->FunctionTable($Datos, '0', 'imprimir', 'images/imp.gif');
$Datos=$Render->FunctionTable($Datos, '1', 'Detalle', 'images/lapiz.png');
echo $Render->Tabla($Datos,'',array('#','Imprimir','Ver','Proveedor','Fecha de pedido','valor','Tipo'),'table table-hover','',true);
