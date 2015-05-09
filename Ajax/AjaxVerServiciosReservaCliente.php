<?php
include_once '../Controller/Reserva.php';
include_once '../Controller/Visual.php';
$Reserva = new Reserva();
$Render = new Visual();
$Datos = $Reserva->VerReservaHecha($_POST['id']);
echo '<center><button class="btn btn-success" onclick="Cargar()">Regresar</button></center>';
echo '<center><button class="btn btn-success" onclick="Pagar('.$_POST['id'].')">Pagar</button></center>';
$Detalle=($Datos['Detalle']);
$Cab=($Datos['Cab']);
echo '<strong>Nombre</strong>:'.$Cab['Nombre'].'<br>';
echo '<strong>Email</strong>:'.$Cab['Email'].'<br>';
echo '<strong>Telefono</strong>:'.$Cab['Telefono'].'<br>';
echo '<strong>valor</strong>:$'.number_format($Cab['valor'],0,'.',',').'<br>';
echo $Render->Tabla($Detalle,'','','table table-hover');