<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelCotizar
{

    public function TotalCotizacion($id_cotizacion)
    {
        $con   = App::$base;
        $sql   = 'SELECT 
                SUM((`cotizacion_servicio`.`cantidad` * `servicios`.`Valor`)) AS `Total`
              FROM
                `cotizacion_servicio`
                INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
              WHERE
                `cotizacion_servicio`.`id_cotizacion`=?';
        $Datos = $con->Record($sql, array($id_cotizacion));
        return $Datos;
    }

    public function ActualizarPrecio($id_cotizacion, $precio)
    {
        $P         = atable::Make('cotizacion');
        $P->Load("id_cotizacion = $id_cotizacion");
        $P->precio = $precio;
        $P->Save();
    }

    public function DetalleCotizacion($id_servicio, $cantidad, $id_cotizacion)
    {
        $P                = atable::Make('cotizacion_servicio');
        $P->id_cotizacion = $id_cotizacion;
        $P->id_servicio   = $id_servicio;
        $P->cantidad      = $cantidad;
        $P->Save();
        return $P->id_cotizacion_servicio;
    }

    public function actualizarEstadoCotizacion($id_cotizacion)
    {
        $P         = atable::Make('cotizacion');
        $P->Load("id_cotizacion=$id_cotizacion");
        $P->estado = 'A';
        $P->Save();
    }

    public function ActualizarDetalleCotizacion($id_cotizacion_servicio, $cantidad, $precio)
    {
        $P           = atable::Make('cotizacion_servicio');
        $P->Load('id_cotizacion_servicio=' . $id_cotizacion_servicio);
        $P->cantidad = $cantidad;
        $P->precio   = $precio;
        $P->Save();
        return $P->id_cotizacion;
    }

    public function CabCotizacion($fecha_inicio, $descripcion, $id_cliente, $fecha_cotizacion = 'now()')
    {
        $P                   = atable::Make('cotizacion');
        $P->id_cliente       = $id_cliente;
        $P->fecha_cotizacion = $fecha_cotizacion;
        $P->fecha_inicio     = $fecha_inicio;
        $P->descripcion      = $descripcion;
        $P->Save();
        return $P->id_cotizacion;
    }

    public function VerCabCotizacion()
    {
        $con   = App::$base;
        $sql   = 'SELECT 
                `cotizacion`.`id_cotizacion`,
                  `cliente`.`Nombres`,
                  `cliente`.`Apellidos`,
                  `cliente`.`Email`,
                  `cliente`.`Telefono`,
                  `cotizacion`.`Fecha_cotizacion`,
                  `cotizacion`.`Fecha_inicio`,
                  `cotizacion`.`Descripcion`,
                  `cotizacion`.`precio`
                FROM
                  `cotizacion`
                  INNER JOIN `cliente` ON (`cotizacion`.`id_cliente` = `cliente`.`id_cliente`)
                WHERE
                  `cotizacion`.`Estado` = ?                    
                order by `cotizacion`.`id_cotizacion` DESC';
        $Datos = $con->TablaDatos($sql, array('P'));
        return $Datos;
    }

    public function VerCotizacion($id_cotizacion)
    {
        $con   = App::$base;
        $sql   = 'SELECT 
                `proveedor`.`Nombre` as "Proveedor",
                `servicios`.`Nombre` as "Servicio",
                `cotizacion_servicio`.`cantidad`,
                `servicios`.`Valor`,
                ( `cotizacion_servicio`.`cantidad`*
                `servicios`.`Valor`) as "total"
              FROM
                `cotizacion_servicio`
                INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
              WHERE
                `cotizacion_servicio`.`id_cotizacion` = ?';
        $Datos = $con->TablaDatos($sql, array($id_cotizacion));
        return $Datos;
    }

    public function VerCotizacionEdit($id_cotizacion)
    {
        $con   = App::$base;
        $sql   = 'SELECT 
                concat(\'<input type="hidden" name="ids[]" value="\', `cotizacion_servicio`.`id_cotizacion_servicio`, \'">\') AS `Proveedor`,
                `servicios`.`Nombre` AS `Servicio`,
                concat(\'<input type="text" name="cantidad[\', `cotizacion_servicio`.`id_cotizacion_servicio`, \']" value="\', `cotizacion_servicio`.`cantidad`, \'">\') AS `cantidad`,
                concat(\'<input type="text" name="Valor[\', `cotizacion_servicio`.`id_cotizacion_servicio`, \']" value="\', `servicios`.`Valor`, \'">\') AS `Valor`,
                (`cotizacion_servicio`.`cantidad` * `servicios`.`Valor`) AS `total`
              FROM
                `cotizacion_servicio`
                INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
                INNER JOIN `cotizacion` ON (`cotizacion_servicio`.`id_cotizacion` = `cotizacion`.`id_cotizacion`)
              WHERE
                `cotizacion_servicio`.`id_cotizacion` = ? ';
        $Datos = $con->TablaDatos($sql, array($id_cotizacion));
        return $Datos;
    }

}
