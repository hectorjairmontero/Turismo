<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelReserva
{

    public function ReservasPaquetes($id_reserva)
    {
        $con = App::$base;
         $sql = 'SELECT 
                `servicios`.`Nombre` AS `servicio`,
                `proveedor`.`Nombre` AS `proveedor`,
                `proveedor`.`Direccion`,
                `proveedor`.`Telefono`,
                `servicios_paquete`.`cantidad_servicios` AS `cantidad`,
                `servicios_paquete`.`valor_unitario_servicio` AS `valor`
              FROM
                `servicios`
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
                INNER JOIN `servicios_paquete` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
                INNER JOIN `reserva` ON (`paquete`.`id_paquete` = `reserva`.`Fk_paquete`)
                where 
                `reserva`.`Id_reserva`=?';
        $Res = $con->TablaDatos($sql, array($id_reserva));
        return $Res;
    }

    function ReservaHecha($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
                    `servicios`.`Nombre` as servicio,
                      `proveedor`.`Nombre` as proveedor,
                      `proveedor`.`Direccion`,
                      `proveedor`.`Telefono`,
                      `cotizacion_servicio`.`cantidad` as cantidad,
                      `cotizacion_servicio`.`Precio` as valor

                    FROM
                      `cotizacion_servicio`
                      INNER JOIN `cotizacion` ON (`cotizacion_servicio`.`id_cotizacion` = `cotizacion`.`id_cotizacion`)
                      INNER JOIN `reserva` ON (`cotizacion`.`id_cotizacion` = `reserva`.`fk_cab_cotizacion`)
                      INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
                      INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
                where 
                `reserva`.`Id_reserva`=?';
        $Res = $con->Records($sql, array($id_reserva));
        return $Res;
    }
    public function ReservasCotizacion($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
                    `servicios`.`Nombre` as servicio,
                      `proveedor`.`Nombre` as proveedor,
                      `proveedor`.`Direccion`,
                      `proveedor`.`Telefono`,
                      `cotizacion_servicio`.`cantidad` as cantidad,
                      `cotizacion_servicio`.`Precio` as valor

                    FROM
                      `cotizacion_servicio`
                      INNER JOIN `cotizacion` ON (`cotizacion_servicio`.`id_cotizacion` = `cotizacion`.`id_cotizacion`)
                      INNER JOIN `reserva` ON (`cotizacion`.`id_cotizacion` = `reserva`.`fk_cab_cotizacion`)
                      INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
                      INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
                where 
                `reserva`.`Id_reserva`=?';
        $Res = $con->TablaDatos($sql, array($id_reserva));
        return $Res;
    }

    public function VerReservasHechas()
    {
        $con = App::$base;
        $sql = 'SELECT 
                `reserva`.`Id_reserva`,
                CONCAT(`cliente`.`Nombres`," ", `cliente`.`Apellidos`) AS `Nombre`,
                `cliente`.`Email`,
                `cliente`.`Telefono`,
                `reserva`.`valor`,
                date(`reserva`.`Fecha_reserva`),
                `reserva`.`Estado`,
                (
                      case `reserva`.`Pago` 
                  when "N" THEN "No ha cancelado"
                  when "S" THEN "Pago"
                  end
                ) as Pago,
                (
                      case `reserva`.`tipo` 
                  when "P" THEN "Paquete"
                  when "C" THEN "Cotizacion"
                  end
                ) as Tipo  

              FROM
                `reserva`
                INNER JOIN `cliente` ON (`reserva`.`fk_cliente` = `cliente`.`id_cliente`)
                 order BY `reserva`.`Fecha_reserva` ASC, Pago ASC, `reserva`.`valor` DESC';
        $Res = $con->TablaDatos($sql, array());
        return $Res;
    }
    public function VerReservasHecha($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `reserva`.`Id_reserva`,
                CONCAT(`cliente`.`Nombres`," ", `cliente`.`Apellidos`) AS `Nombre`,
                `cliente`.`Email`,
                `cliente`.`Telefono`,
                `reserva`.`valor`,
                `reserva`.`Fecha_reserva`,
                `reserva`.`Estado`,
                (
                      case `reserva`.`Pago` 
                  when "N" THEN "No ha cancelado"
                  when "S" THEN "Pago"
                  end
                ) as Pago,
                (
                      case `reserva`.`tipo` 
                  when "P" THEN "Paquete"
                  when "C" THEN "Cotizacion"
                  end
                ) as Tipo  

              FROM
                `reserva`
                INNER JOIN `cliente` ON (`reserva`.`fk_cliente` = `cliente`.`id_cliente`)
                where `reserva`.`Id_reserva`=?';
        $Res = $con->Record($sql, array($id_reserva));
        return $Res;
    }

    public function ReservarPaquete($Fk_paquete, $fk_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago)
    {
        $R                = atable::Make('reserva');
        $R->fk_paquete    = $Fk_paquete;
        $R->fk_cliente    = $fk_cliente;
        $R->valor         = $valor;
        $R->fecha_pedido  = $Fecha_pedido;
        $R->fecha_reserva = $Fecha_reserva;
        $R->estado        = $Estado;
        $R->pago          = $Pago;
        $R->tipo          = 'P';
        $R->Save();
        return $R->id_reserva;
    }

    public function Reserva($Fk_paquete, $fk_cliente, $valor, $Fecha_pedido, $Fecha_reserva, $Estado, $Pago, $cab_cotizacion = NULL)
    {
        $tipo = 'P';
        if (!is_null($cab_cotizacion))
        {
            $tipo = 'C';
        }
        $R                    = atable::Make('reserva');
        $R->fk_paquete        = $Fk_paquete;
        $R->fk_cliente        = $fk_cliente;
        $R->valor             = $valor;
        $R->fecha_pedido      = $Fecha_pedido;
        $R->fecha_reserva     = $Fecha_reserva;
        $R->estado            = $Estado;
        $R->pago              = $Pago;
        $R->fk_cab_cotizacion = $cab_cotizacion;
        $R->tipo              = $tipo;
        $R->Save();
        return $R->id_reserva;
    }

    public function Pagar($Id_reserva)
    {
        $R = atable::Make('reserva');
        $R->Load('Id_reserva=' . $Id_reserva);
        if (!is_null($R->id_reserva))
        {
            $R->pago   = 'S';
            $R->estado = 'Confirmado';
            $R->Save();
        }
        return $R->id_reserva;
    }

    public function ReservaPaga($Id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
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
        $Res = $con->Records($sql, array($Id_reserva, 'S'));
        return $Res;
    }

    public function VerCotizacion($id_cotizacion)
    {
        $con = App::$base;
        $sql = 'SELECT `reserva`.`Id_reserva`,
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
        $Res = $con->Records($sql, array($id_cotizacion, 'cotizacion'));
        return $Res;
    }

}
