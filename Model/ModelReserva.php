<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelReserva
{

    public function Reserva($Fk_paquete, $fk_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago)
    {
        $R = atable::Make('reserva');
        $R->fk_paquete=$Fk_paquete;
        $R->fk_cliente=$fk_cliente; 
        $R->valor=$valor; 
        $R->fecha_pedido=$Fecha_pedido; 
        $R->fecha_reserva=$Fecha_reserva; 
        $R->estado=$Estado; 
        $R->pago=$Pago;
        $R->Save();
        return $R->id_reserva;
    }
    public function Pagar($Id_reserva)
    {
        $R = atable::Make('reserva');
        $R->Load('Id_reserva='.$Id_reserva);
        if(!is_null($R->id_reserva))
        {
            $R->Pago='S';
            $R->Save();
        }
        return $R->id_reserva;
    }
}