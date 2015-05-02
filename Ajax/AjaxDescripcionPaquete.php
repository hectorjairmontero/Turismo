<?php

if (isset($_POST['Paquetes'])&&$_POST['Paquetes']!='0')
{
    include_once '../Controller/Servicios.php';
    include_once '../Controller/Visual.php';
    $Descripcion  = new Servicios();
    $Render       = new Visual();
    $id_paquete   = $_POST['Paquetes'];
    $Datos        = $Descripcion->VerDescripcionPaquete($id_paquete);
    $Nombre       = $Datos['Nombre'];
    $Valor        = $Datos['Valor'];
    $Fecha_inicio = $Datos['Fecha_inicio'];
    $Fecha_fin    = $Datos['Fecha_fin'];
    $Descripcion  = $Datos['Descripcion'];
    echo '<div class="row"><div class="col-lg-12"><input type="text" value="'.$Nombre.'" name="Nombre" class="form-control"></div></div>';
    echo '<div class="row"><div class="col-lg-12"><h5>Valor: $'.number_format($Valor, 0, ',', '.').'</h5>';
    echo '<div class="row"><div class="col-lg-12"><label from="Descripcion" class="form-control">Descripcion:</label><textarea rows="5" name="Descripcion" value="s" class="form-control">'.$Descripcion.'</textarea></div></div>';
    
}
else
{
    echo null;
}