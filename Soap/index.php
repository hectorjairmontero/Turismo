<?php
include_once '../Controller/Servicios.php';
include_once '../Controller/Proveedor.php';
require_once "../Controller/Nusoap/nusoap.php";
function VerPaquetesServicios()
{
    $Paquetes=new Servicios();
    return json_encode($Paquetes->VerPaquetesConServicios());
}
function CuentasProveedorTotal($Cod_proveedor,$FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    return json_encode($Cuentas->EstadoCuentaTotal($Cod_proveedor, $FechaIncial, $FechaFinal));
}
function CuentaEstadoPaquete($Cod_proveedor,$FechaIncial, $FechaFinal)
{
    $Cuentas = new Proveedor();
    return json_encode($Cuentas->EstadoCuentaPaquete($Cod_proveedor, $FechaIncial, $FechaFinal));
}
$server = new soap_server();
$server->register('VerPaquetesServicios');
$server->register('CuentaEstadoPaquete');
$server->register('CuentasProveedorTotal');
@$server->service($HTTP_RAW_POST_DATA);
?>