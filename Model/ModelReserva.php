<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelReserva
{

    public function Reserva($Fk_paquete, $fk_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago,$cab_cotizacion=NULL)
    {
        $R = atable::Make('reserva');
        $R->fk_paquete=$Fk_paquete;
        $R->fk_cliente=$fk_cliente; 
        $R->valor=$valor; 
        $R->fecha_pedido=$Fecha_pedido; 
        $R->fecha_reserva=$Fecha_reserva; 
        $R->estado=$Estado; 
        $R->pago=$Pago;
        $R->fk_cab_cotizacion=$cab_cotizacion;
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
            $R->estado='Confirmado';
            $R->Save();
        }
        return $R->id_reserva;
    }
    public function ReservaPaga($Id_reserva)
    {
        $con = App::$base;
        $sql='SELECT 
            `reserva`.`Id_reserva`,
            `reserva`.`Fk_paquete` AS "Paquete",
            `reserva`.`valor` as "valor_reserva",
            `reserva`.`Fecha_pedido`,
            `reserva`.`Fecha_reserva`,
            `reserva`.`Estado`,
            `reserva`.`Pago`,
            `paquete`.`Nombre`,
            `paquete`.`Valor`,
            `paquete`.`Fecha_inicio`,
            `paquete`.`Fecha_fin`
          FROM
            `reserva`
            INNER JOIN `paquete` ON (`reserva`.`Fk_paquete` = `paquete`.`id_paquete`)
            where `reserva`.`Id_reserva`=?
            and `reserva`.`Pago`=?';
        $Res=$con->Records($sql,array($Id_reserva,'S'));
        return $Res;
    }
    public function VerCotizacion($id_cotizacion)
    {
        $con = App::$base;
        $sql='SELECT `reserva`.`Id_reserva`,
                  `reserva`.`valor` AS `valor_reserva`,
                  `reserva`.`Fk_paquete` AS "Paquete",
                  `reserva`.`Fecha_pedido`,
                  `reserva`.`Fecha_reserva`,
                  `reserva`.`Pago`,
                  `paquete`.`Nombre`,
                  `paquete`.`Valor`,
                  `paquete`.`Fecha_inicio`,
                  `paquete`.`Fecha_fin`
                FROM
                  `reserva`
                  INNER JOIN `paquete` ON (`reserva`.`Fk_paquete` = `paquete`.`id_paquete`)
                WHERE
                  `reserva`.`Id_reserva`=? AND 
                  `reserva`.`Estado` = ?';
        $Res=$con->Records($sql,array($id_cotizacion,'cotizacion'));
        return $Res;
        
    }
}