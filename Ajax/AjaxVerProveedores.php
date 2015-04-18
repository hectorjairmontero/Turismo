<?php
include_once '../Controller/Proveedor.php';
include_once '../Controller/Visual.php';
$Render = new Visual();
$Ver = new Proveedor();
$List=$Ver->VerProveedores();
$List=$Render->FormatoTable($List);
$List=$Render->FunctionTable($List,0,'Ver','images/lapiz.png');
$List=$Render->FunctionRecortarTexto($List,7,30);
$Tabla = $Render->Tabla($List,'',array('Editar','Proveedor','Teléfono','Email','Nit','Estado','Código','Descripcion'),'table table-hover');
echo($Tabla);