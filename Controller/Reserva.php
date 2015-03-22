<?php
include_once '../Model/ModelReserva.php';
include_once '../Controller/Servicios.php';

class Reserva
{
    public function Reservar($id_paquete,$id_cliente,$valor,$Fecha_pedido,$Fecha_reserva,$Estado,$Pago)
    {
        
    }
    public function Factura($Id_reserva)
    {
        $Ser=new Servicios();
        $Reserva = new ModelReserva();
        $Res=array();
        $Datos=$Reserva->ReservaPaga($Id_reserva);
        foreach ($Datos as $Temp)
        {
            $Res=$Temp;
            $Res['Servicios']=$Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
    }
}