<?php

include_once '../Controller/Visual.php';
include_once '../Controller/Servicios.php';
$Render    = new Visual();
$Servicios = new Servicios();
$id_proveedor=$_POST['proveedor'];
echo $Render->Select($Servicios->VerServiciosProveedor($id_proveedor), '', '','Servicios','','','','form-control');