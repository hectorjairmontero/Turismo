<?php

include_once '../Controller/Servicios.php';
include_once '../Controller/Proveedor.php';
include_once '../Controller/Reserva.php';
include_once '../Controller/Visual.php';
require_once "../Controller/Nusoap/nusoap.php";

function VerPaquetes()
{
    $Paquetes = new Servicios();
    return json_encode($Paquetes->VerPaquetes());
}

function VerPaquetesServicios()
{
    $Paquetes = new Servicios();
    return json_encode($Paquetes->VerPaquetesConServicios());
}

function TotalReservaCotizacion($Cod_proveedor, $FechaIncial, $FechaFinal)
{
 
    $Cuentas = new Proveedor();
    $Res = $Cuentas->TotalReservaCotizacion($Cod_proveedor, $FechaIncial, $FechaFinal);
    return json_encode($Res);
}
function TotalValorServicios($Cod_proveedor, $id_servicio,$FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    $Res = $Cuentas->TotalServiciosReservaCotizacion($Cod_proveedor, $id_servicio,$FechaIncial, $FechaFinal);
    return json_encode($Res);
}

function CuentasProveedorTotal($Cod_proveedor, $FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    $Res     = $Cuentas->EstadoCuentaTotal($Cod_proveedor, $FechaIncial, $FechaFinal);
    return json_encode($Res);
}

function CuentaEstadoPaquete($Cod_proveedor, $FechaIncial, $FechaFinal, $Paquete)
{
    $Cuentas = new Proveedor();
    return json_encode($Cuentas->EstadoCuentaPaquete($Cod_proveedor, $FechaIncial, $FechaFinal, $Paquete));
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
    $Res = $Ver->VerServiciosProveedorSoap('', $cod_proveedor);
    return json_encode($Res);
}
function VerReservasProveedor($cod_proveedor)   
{
    $Ver = new Reserva();
    $Res = $Ver->VerReservasProveedor($cod_proveedor);
    return json_encode($Res);
}
function CambiarDisponibilidadServicio($cod_proveedor,$id_servicio)
{
    $Ver = new Servicios();
    return $Ver->CambiarDisponibilidadServicio($cod_proveedor,$id_servicio);    
}
$server = new soap_server();
$server->register('GuardarServicios');
$server->register('CambiarDisponibilidadServicio');
$server->register('VerReservasProveedor');
$server->register('VerPaquetes');
$server->register('VerServiciosProveedor');
$server->register('VerPaquetesServicios');
$server->register('CuentaEstadoPaquete');
$server->register('CuentasProveedorTotal');
$server->register('TotalReservaCotizacion');
$server->register('TotalValorServicios');
@$server->service($HTTP_RAW_POST_DATA);
?>