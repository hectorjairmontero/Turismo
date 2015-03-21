<?php
require_once "lib/nusoap.php";
include_once './Servicios.php';

function DimensionesTematicasCategorias()
{
    $Datos = new Servicios();
    return $Datos->DimensionesTematicasCategorias();
}

function DatosTangaraHTML($id_indicador, $Municipio)
{
    $Datos = new Servicios();
    return $Datos->DatosTangaraHTML($id_indicador, $Municipio);
}

function DatosTangara($id_indicador, $Municipio)
{
    $Datos = new Servicios();
    return $Datos->DatosTangara($id_indicador, $Municipio);
}

function Municipios()
{
    $Datos=new Servicios();
    return $Datos->Municipios();
}

function Indicadores()
{
    $Datos=new Servicios();
    return $Datos->Indicadores();
}
$server = new soap_server();

$server->register('DimensionesTematicasCategorias');
$server->register('Indicadores');
$server->register('Municipios');
$server->register('DatosTangara');
$server->register('DatosTangaraHTML');
@$server->service($HTTP_RAW_POST_DATA);
?>