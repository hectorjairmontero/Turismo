<?php

include_once '../Controller/Servicios.php';
include_once '../Controller/Proveedor.php';
include_once '../Controller/Visual.php';
require_once "../Controller/Nusoap/nusoap.php";

function VerPaquetesServicios()
{
    $Paquetes = new Servicios();
    return json_encode($Paquetes->VerPaquetesConServicios());
}

function CuentasProveedorTotal($Cod_proveedor, $FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    return json_encode($Cuentas->EstadoCuentaTotal($Cod_proveedor, $FechaIncial, $FechaFinal));
}

function CuentaEstadoPaquete($Cod_proveedor, $FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    return json_encode($Cuentas->EstadoCuentaPaquete($Cod_proveedor, $FechaIncial, $FechaFinal));
}

function GuardarServicios($cod_proveedor, $nombre_servicio, $valor)
{
    $Guardar = new Servicios();
    $id      = $Guardar->NuevoServicio($cod_proveedor, $nombre_servicio, $valor);
    return $id;
}
function VerServiciosProveedor($cod_proveedor)
{
    $Ver = new Servicios();
    $Fomato = new Visual();
    $Res=$Ver->VerServiciosProveedor('', $cod_proveedor);
    return json_encode($Res);
}

$server = new soap_server();
$server->register('GuardarServicios');
$server->register('VerServiciosProveedor');
$server->register('VerPaquetesServicios');
$server->register('CuentaEstadoPaquete');
$server->register('CuentasProveedorTotal');
@$server->service($HTTP_RAW_POST_DATA);
?>