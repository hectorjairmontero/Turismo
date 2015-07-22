<?php

include_once '../Model/ModelReserva.php';
include_once '../Controller/Servicios.php';

class Reserva {

    public function VerReservasHechas() {
        $Reservar = new ModelReserva();
        return $Reservar->VerReservasHechas();
    }

    public function PagarReserva($id_reserva) {
        $Reservar = new ModelReserva();
        $id = $Reservar->Pagar($id_reserva);
    }

    public function ReservarPaquete($id_paquete, $id_cliente, $Fecha_reserva, $Pago) {
        $Reservar = new ModelReserva();
        $Servicios = new Servicios();
        $Datos = $Servicios->VerDescripcionPaquete($id_paquete);
        $id = $Reservar->ReservarPaquete($id_paquete, $id_cliente, $Datos['Valor'], 'now()', $Fecha_reserva, 'Confirmado', $Pago);
        return $id;
    }

    public function Reservar($id_paquete, $id_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago, $cab_cotizacion = NULL) {
        $Reservar = new ModelReserva();
        $id = $Reservar->Reserva($id_paquete, $id_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago, $cab_cotizacion);
        return $id;
    }

    public function VerCotizacion($id_cotizacion) {
        $Ser = new Servicios();
        $Cot = new ModelReserva();
        $Datos = $Cot->VerCotizacion($id_cotizacion);
        $Res = array();
        foreach ($Datos as $Temp) {
            $Res = $Temp;
            $Res['Servicios'] = $Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
    }

    public function Factura($Id_reserva) {
        $Ser = new Servicios();
        $Reserva = new ModelReserva();
        $Res = array();
        $Datos = $Reserva->ReservaPaga($Id_reserva);
        foreach ($Datos as $Temp) {
            $Res = $Temp;
            $Res['Servicios'] = $Ser->ServiciosXPaquete($Temp['Paquete']);
        }
        return $Res;
    }

    private function ReservasPaquetes($id_reserva) {
        $Reserva = new ModelReserva();
        $Res = $Reserva->ReservasPaquetes($id_reserva);
        return $Res;
    }

    private function ReservasCotizacion($id_reserva) {
        $Reserva = new ModelReserva();
        $Res = $Reserva->ReservasCotizacion($id_reserva);
        return $Res;
    }

    private function ReservaHecha($id_reserva) {
        $Reserva = new ModelReserva();
        $Res = $Reserva->VerReservasHecha($id_reserva);
        return $Res;
    }

    public function VerReservaHecha($id_reserva) {
        $Cab = $this->ReservaHecha($id_reserva);
        $Detalle = array();
        if ($Cab['Tipo'] == 'Paquete') {
            $Detalle = $this->ReservasPaquetes($id_reserva);
        } else {
            $Detalle = $this->ReservasCotizacion($id_reserva);
        }
        $Res = (array('Cab' => $Cab, 'Detalle' => $Detalle));
        return ($Res);
    }

    public function VerReservasPagasProveedores($FechaInicio = '', $FechaFin = '',$Proveedor='') {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->VerReservasPagasProveedores($FechaInicio, $FechaFin,$Proveedor);
        return $Datos;
    }

    private function VerDetalleReservaCotizacion($id_reserva) {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->VerDetalleReservaCotizacion($id_reserva);
        return $Datos;
    }

    private function VerDetalleReservaPaquete($id_reserva) {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->VerDetalleReservaPaquete($id_reserva);
        return $Datos;
    }

    private function tipo($id_reserva) {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->tipo($id_reserva);
        return $Datos;
    }

    public function VerdetalleReserva($id_reserva) {
        $tipo = $this->tipo($id_reserva);
        $Datos = '';
        if ($tipo == 'C') {
            $Datos = $this->VerDetalleReservaCotizacion($id_reserva);
        } else {
            $Datos = $this->VerDetalleReservaPaquete($id_reserva);
        }
        return $Datos;
    }

    public function DatosReserva($id_reserva) {
        $Reservas = new ModelServicios();
        $Datos = $Reservas->DatosReserva($id_reserva);
        return $Datos;
    }

    public function VerReservasProveedor($cod_proveedor) 
    {
        $Reservas = new ModelReserva();
        $Datos = $Reservas->VerReservasProveedor($cod_proveedor);
        return $Datos;
    }

}
        