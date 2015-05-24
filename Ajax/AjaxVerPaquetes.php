<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Visual.php';
$Paquetes=new Servicios();
$Render = new Visual();
$Datos = $Render->FormatoSelect($Paquetes->VerPaquetes());
$Datos = $Render->img($Datos , 8,'img-responsive');
$Datos = $Render->EliminarRegistro($Datos , 9);
$Datos = $Render->EliminarRegistro($Datos , 9);
$Datos2=NULL;
foreach($Datos as $Temp)
{
    $url = 'CargarFotos.php?id='.$Temp[0];
    $Temp[]='<script></script>'
            . '<form method="post" action="'.$url.'" enctype="multipart/form-data">'
            . '<input type="file" name="image" id="image" >'
            . '<button onclick="CargarFoto('.$Temp[0].')">'
            . '<img src="images/upload.png">'
            . '</button>'
            . '</form>';
    $Datos2[]=$Temp;
}
$Datos=$Datos2;        
$Datos = $Render->GenerarLinkRegistro($Datos , 0,'images/lapiz.png','ver_paquetes.html?id');
$Datos = $Render->FunctionTable($Datos, 1, 'Bloquear', 'images/x.png');
$Datos = $Render->FormatoNumerico($Datos , 3,'$',0,'.',',');
$enc=array('Ver','Eliminar','Nombre','Valor','Fecha inicio','Fecha fin','Municipio','Descripcion','Foto','Cambiar imagen');
echo $Render->Tabla($Datos,'',$enc,"table table-striped");