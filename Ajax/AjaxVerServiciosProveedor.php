<?php
include_once '../Controller/Visual.php';
include_once '../Controller/Servicios.php';
$Render = new Visual();
$Proveedor = new Servicios();
$Proveedores = $Proveedor->VerProveedores();
echo '<div="row">';
echo '<div class="col-lg-1"><label from ="Proveedor">Proveedor</label></div><div class="col-lg-11">'.$Render->Select($Proveedores,'','','id_proveedores','buscarservicios()','','','form-control').'</div>';
echo '</div>';