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
    public function PagarReserva($id_reserva)
    {
        $Reservar = new ModelReserva();
        $id=$Reservar->Pagar($id_reserva);
    }

    public function ReservarPaquete($id_paquete, $id_cliente, $Fecha_reserva, $Pago)
    {
        $Reservar  = new ModelReserva();
        $Servicios = new Servicios();
        $Datos     = $Servicios->VerDescripcionPaquete($id_paquete);
        $id        = $Reservar->ReservarPaquete($id_paquete, $id_cliente, $Datos['Valor'], 'now()', $Fecha_reserva, 'Confirmado', $Pago);
        return $id;
    }

    public function Reservar($id_paquete, $id_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago, $cab_cotizacion = NULL)
    {
        $Reservar = new ModelReserva();
        $id       = $Reservar->Reserva($id_paquete, $id_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago, $cab_cotizacion);
        return $id;
    }

    public function VerCotizacion($id_cotizacion)
    {
        $Ser   = new Servicios();
        $Cot   = new ModelReserva();
        $Datos = $Cot->VerCotizacion($id_cotizacion);
        $Res   = array();
        foreach ($Datos as $Temp)
        {
            $Res              = $Temp;
            $Res['Servicios'] = $Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
    }

    public function Factura($Id_reserva)
    {
        $Ser     = new Servicios();
        $Reserva = new ModelReserva();
        $Res     = array();
        $Datos   = $Reserva->ReservaPaga($Id_reserva);
        foreach ($Datos as $Temp)
        {
            $Res              = $Temp;
            $Res['Servicios'] = $Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
    }

    private function ReservasPaquetes($id_reserva)
    {
        $Reserva = new ModelReserva();
        $Res     = $Reserva->ReservasPaquetes($id_reserva);
        return $Res;
    }

    private function ReservasCotizacion($id_reserva)
    {
        $Reserva = new ModelReserva();
        $Res     = $Reserva->ReservasCotizacion($id_reserva);
        return $Res;
    }

    private function ReservaHecha($id_reserva)
    {
        $Reserva = new ModelReserva();
        $Res     = $Reserva->VerReservasHecha($id_reserva);
        return $Res;
    }

    public function VerReservaHecha($id_reserva)
    {
        $Cab     = $this->ReservaHecha($id_reserva);
        $Detalle = array();
        if ($Cab['Tipo'] == 'Paquete')
        {
            $Detalle = $this->ReservasPaquetes($id_reserva);
        }
        else
        {
            $Detalle = $this->ReservasCotizacion($id_reserva);
        }
        $Res = (array('Cab' => $Cab, 'Detalle' => $Detalle));
        return ($Res);
    }
    public function VerReservasPagasProveedores($FechaInicio='',$FechaFin='')
    {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->VerReservasPagasProveedores($FechaInicio,$FechaFin);
        return $Datos;
    }

}
