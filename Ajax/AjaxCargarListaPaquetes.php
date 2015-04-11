<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Render     = new Visual();
$Servicios  = new Servicios();
$id_paquete = $_POST['Paquetes'];
echo'<pre>';
$Datos=$Render->FormatoSelect($Servicios->ServiciosXPaquete($id_paquete));
$En=array('#','Servicio','Precio','Disponible','Proveedor','Dirección','Telefono','Correo','Cantidad<br/>por paquete','Valor');
echo $Render->Tabla($Datos,'',$En,'table','',TRUE);