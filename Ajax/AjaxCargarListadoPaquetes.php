<?php
if(isset($_POST['Paquetes']))
{
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Render     = new Visual();
$Servicios  = new Servicios();
$id_paquete = $_POST['Paquetes'];
echo'<pre>';
$Datos=$Render->FormatoSelect($Servicios->ServiciosXPaquete($id_paquete));
$Datos=$Render->FormatoNumerico($Datos,'1','$',0);
$Datos=$Render->FormatoNumerico($Datos,'6','',0);
$Datos=$Render->FormatoNumerico($Datos,'7','$',0);
$En=array('#','Servicio','Precio','Proveedor','Direccion','Telefono','Email','incluidos','Valor');
echo $Render->Tabla($Datos,'',$En,'table','',TRUE);
}