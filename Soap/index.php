<?php
include_once '../Controller/Servicios.php';
require_once "../Controller/Nusoap/nusoap.php";
function VerPaquetesServicios()
{
    $Paquetes=new Servicios();
    return json_encode($Paquetes->VerPaquetesConServicios());
}
$server = new soap_server();
$server->register('VerPaquetesServicios');
@$server->service($HTTP_RAW_POST_DATA);
?>