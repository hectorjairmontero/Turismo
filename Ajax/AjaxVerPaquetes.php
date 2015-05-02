<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Paquetes=new Servicios();
$Render = new Visual();
$Datos = $Render->FormatoSelect($Paquetes->VerPaquetes());
$Datos = $Render->img($Datos , 6,'img-responsive');
$Datos = $Render->EliminarRegistro($Datos , 7);
$Datos = $Render->FormatoNumerico($Datos , 2,'$',0,'.',',');
//$Datos = $Render->EliminarRegistro($Datos , 8);
$enc=array('Codigo','Nombre','Valor','Fecha inicio','Fecha fin','Descripcion','Foto');
echo $Render->Tabla($Datos,'',$enc,"table table-striped");