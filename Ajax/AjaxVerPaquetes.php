<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Paquetes=new Servicios();
$Render = new Visual();
$Datos = $Render->FormatoSelect($Paquetes->VerPaquetes());
$Datos = $Render->img($Datos , 8,'img-responsive');
$Datos = $Render->EliminarRegistro($Datos , 9);
$Datos = $Render->EliminarRegistro($Datos , 9);
$Datos = $Render->GenerarLinkRegistro($Datos , 0,'images/lapiz.png','ver_paquetes.html?id');
$Datos = $Render->FunctionTable($Datos, 1, 'Bloquear', 'images/x.png');
$Datos = $Render->FormatoNumerico($Datos , 3,'$',0,'.',',');
$enc=array('Ver','Eliminar','Nombre','Valor','Fecha inicio','Fecha fin','Municipio','Descripcion','Foto');
echo $Render->Tabla($Datos,'',$enc,"table table-striped");