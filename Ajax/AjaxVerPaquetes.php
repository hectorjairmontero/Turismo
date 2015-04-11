<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Paquetes=new Servicios();
$Render = new Visual();
$Datos = $Render->FormatoSelect($Paquetes->VerPaquetes());
$enc=array('Codigo','Nombre','Valor','Fecha inicio','Fecha fin','Disponible','Vigente');
echo $Render->Tabla($Datos,'',$enc,"table table-striped");