<?php
include_once '../Model/ModelReserva.php';
include_once '../Controller/Servicios.php';

class Reserva
{
    
    public function VerReservasHechas()
    {
        $Reservar = new ModelReserva();
        return $Reservar->VerReservasHechas();
    }
    public function ReservarPaquete($id_paquete,$id_cliente,$Fecha_reserva,$Pago)
    {
        $Reservar = new ModelReserva();
        $Servicios = new Servicios();
        $Datos=$Servicios->VerDescripcionPaquete($id_paquete);
        $id=$Reservar->ReservarPaquete($id_paquete,$id_cliente,$Datos['Valor'],'now()',$Fecha_reserva,'Confirmado',$Pago);
        return $id;
    }
    public function Reservar($id_paquete,$id_cliente,$valor,$Fecha_pedido,$Fecha_reserva,$Estado,$Pago,$cab_cotizacion=NULL)
    {
        $Reservar = new ModelReserva();
        $id=$Reservar->Reserva($id_paquete, $id_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago,$cab_cotizacion);
        return $id;
    }
    public function VerCotizacion($id_cotizacion)
    {
        $Ser=new Servicios();
        $Cot=new ModelReserva();
        $Datos = $Cot->VerCotizacion($id_cotizacion);
        $Res=array();
        foreach ($Datos as $Temp)
        {
            $Res=$Temp;
            $Res['Servicios']=$Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
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