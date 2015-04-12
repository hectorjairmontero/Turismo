<?php
include_once '../Controller/Servicios.php';
$Servicios = new Servicios();
$Paquetes=$_POST['Paquetes'];
$Servicio=$_POST['Servicio'];
$Cantidad=$_POST['Cantidad'];
$Precio=$_POST['Precio'];
$Porcentaje=$_POST['Porcentaje'];

$Servicios->ArmarPaquetes($Paquetes, $Servicio, $Cantidad, $Precio, $Porcentaje);