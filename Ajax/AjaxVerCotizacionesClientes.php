<?php
include_once '../Controller/Cotizar.php';
include_once '../Controller/Visual.php';
$cotizar = new Cotizar();
$Render = new Visual();
$id_cotizacion=$_POST['id'];
$Res = $cotizar->VerCotizacionEdit($id_cotizacion,'1');
$Total=$cotizar->Total($id_cotizacion);
$Datos=$Render->Tabla($Res,'',array('Eliminar','Proveedor','Servicio','Cantidad','Valor','Valor total'),'table');
echo json_encode(array('Datos'=>$Datos,'Total'=>'Precio estimado $'.number_format($Total,0,'.',',')));