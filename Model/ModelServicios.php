<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelServicios
{

    public function DatosReserva($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
            `reserva`.`Id_reserva`,
            `reserva`.`valor`,
            `reserva`.`Fecha_pedido`,
            `reserva`.`Fecha_reserva`,
            concat(IFNULL(`proveedor1`.`Nombre`, ""), IFNULL(`proveedor`.`Nombre`, "")) AS `Nombre`
          FROM
            `reserva`
            LEFT OUTER JOIN `cotizacion` ON (`reserva`.`fk_cab_cotizacion` = `cotizacion`.`id_cotizacion`)
            LEFT OUTER JOIN `paquete` ON (`reserva`.`Fk_paquete` = `paquete`.`id_paquete`)
            LEFT OUTER JOIN `servicios_paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
            LEFT OUTER JOIN `servicios` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
            LEFT OUTER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
            LEFT OUTER JOIN `cotizacion_servicio` ON (`cotizacion`.`id_cotizacion` = `cotizacion_servicio`.`id_cotizacion`)
            LEFT OUTER JOIN `servicios` `servicios1` ON (`cotizacion_servicio`.`id_servicio` = `servicios1`.`id_servicios`)
            LEFT OUTER JOIN `proveedor` `proveedor1` ON (`servicios1`.`fk_Proveedor` = `proveedor1`.`id_proveedor`)
          WHERE
            `reserva`.`Id_reserva` = ? GROUP BY  1';
        
        $Res = $con->Record($sql, array($id_reserva));
        return $Res;
    }

    public function tipo($id_reserva)
    {
        $S = atable::Make('reserva');
        $S->Load("`reserva`.`Id_reserva`= $id_reserva");
        return $S->tipo;
    }

    public function VerDetalleReservaCotizacion($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
            `cotizacion`.`Descripcion`,
            `servicios`.`Nombre`,
            `reserva`.`Fecha_reserva`,
            `cotizacion_servicio`.`cantidad`,
            `cotizacion_servicio`.`Precio`,
            (`cotizacion_servicio`.`cantidad` * `cotizacion_servicio`.`Precio`) AS `total`
          FROM
            `reserva`
            INNER JOIN `cotizacion` ON (`reserva`.`fk_cab_cotizacion` = `cotizacion`.`id_cotizacion`)
            INNER JOIN `cotizacion_servicio` ON (`cotizacion_servicio`.`id_cotizacion` = `cotizacion`.`id_cotizacion`)
            INNER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
            where
            `reserva`.`Id_reserva` =?';
        $Res = $con->TablaDatos($sql, array($id_reserva));
        return $Res;
    }

    public function VerDetalleReservaPaquete($id_reserva)
    {
        $con = App::$base;
        $sql = 'SELECT 
            `paquete`.`Nombre` as paquete,
            `servicios`.`Nombre`,
            `reserva`.`Fecha_reserva`,
            `servicios_paquete`.`cantidad_servicios`,
            `servicios_paquete`.`valor_unitario_servicio`,
            (`servicios_paquete`.`cantidad_servicios` * `servicios_paquete`.`valor_unitario_servicio`) AS `total`
          FROM
            `servicios`
            INNER JOIN `servicios_paquete` ON (`servicios`.`id_servicios` = `servicios_paquete`.`fk_servicio`)
            INNER JOIN `paquete` ON (`servicios_paquete`.`fk_paquete` = `paquete`.`id_paquete`)
            INNER JOIN `reserva` ON (`paquete`.`id_paquete` = `reserva`.`Fk_paquete`)
          WHERE
            `reserva`.`Id_reserva` = ?';
        $Res = $con->TablaDatos($sql, array($id_reserva));
        return $Res;
    }

    public function CambiarEstadoServicio($est, $id_servicio)
    {
        $S                 = atable::Make('servicios');
        $S->Load('id_servicios =' . $id_servicio);
        $S->estado         = $est;
        $S->disponibilidad = $est;
        $S->Save();
    }

    public function Eliminar($id_servicio_paquete)
    {
        $S = atable::Make('servicios_paquete');
        $S->Load('id_servicios_paquete =' . $id_servicio_paquete);
        $S->Delete();
    }

    public function VerReservasPagasProveedores($FechaInicio = '', $FechaFin = '')
    {
        $con = App::$base;
        $sql = 'SELECT 
            `reserva`.`Id_reserva`,
            `reserva`.`Id_reserva` as imp,
            CONCAT(IFNULL(`proveedor`.`Nombre`, ""), IFNULL(`proveedor1`.`Nombre`, "")) AS `nombre`,
            `reserva`.`valor`,
          CASE `reserva`.`tipo`
          WHEN "C" THEN "Cotizacion"
          WHEN "P" THEN "Paquete"
          END as "Tipo"
          FROM
            `reserva`
            LEFT OUTER JOIN `cotizacion` ON (`reserva`.`fk_cab_cotizacion` = `cotizacion`.`id_cotizacion`)
            LEFT OUTER JOIN `cotizacion_servicio` ON (`cotizacion_servicio`.`id_cotizacion` = `cotizacion`.`id_cotizacion`)
            LEFT OUTER JOIN `paquete` ON (`reserva`.`Fk_paquete` = `paquete`.`id_paquete`)
            LEFT OUTER JOIN `servicios_paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
            LEFT OUTER JOIN `servicios` `servicios1` ON (`servicios_paquete`.`fk_servicio` = `servicios1`.`id_servicios`)
            LEFT OUTER JOIN `proveedor` `proveedor1` ON (`servicios1`.`fk_Proveedor` = `proveedor1`.`id_proveedor`)
            LEFT OUTER JOIN `servicios` ON (`cotizacion_servicio`.`id_servicio` = `servicios`.`id_servicios`)
            LEFT OUTER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
          WHERE
            `reserva`.`Estado` = ?
          GROUP BY 1';
        $Res = $con->TablaDatos($sql, array('Confirmado', $FechaInicio, $FechaFin));
        return $Res;
    }

    public function VerServicioPaquete($id_servicio_paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `servicios`.`Nombre` as "servicio",
                `proveedor`.`Nombre` as "proveedor",
                `servicios_paquete`.`cantidad_servicios`
              FROM
                `servicios_paquete`
                INNER JOIN `servicios` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
              WHERE
                `servicios_paquete`.`id_servicios_paquete` = ?
                and `servicios`.`Disponibilidad`=?';
        $Res = $con->Record($sql, array($id_servicio_paquete, 'S'));
        return $Res;
    }

    public function EditarPaquete($id_paquete, $Nombre, $Descripcion, $id_muncipio, $Fecha_inicio, $Fecha_fin)
    {
        $S = atable::Make('paquete');
        $S->Load('id_paquete =' . $id_paquete);
        if (!is_null($S->id_paquete))
        {
            $S->nombre       = $Nombre;
            $S->descripcion  = $Descripcion;
            $S->id_muncipio  = $id_muncipio;
            $S->fecha_inicio = $Fecha_inicio;
            $S->fecha_fin    = $Fecha_fin;
            $S->Save();
        }
        return $S->id_paquete;
    }

    public function ActualizarPrecioTotalPaquete($id_paquete, $Total)
    {
        $S = atable::Make('paquete');
        $S->Load('id_paquete =' . $id_paquete);
        if (!is_null($S->id_paquete))
        {
            $S->valor = $Total;
            $S->Save();
        }
        else
        {
            echo 'No';
        }
        return $S->id_paquete;
    }

    public function PrecioTotalPaquete($id_paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
                SUM(`servicios_paquete`.`valor_unitario_servicio`*`servicios_paquete`.`cantidad_servicios`) as "Total"
              FROM
                `servicios_paquete`
              WHERE
                `servicios_paquete`.`fk_paquete` = ?';
        $Res = $con->Record($sql, array($id_paquete));
        return $Res;
    }

    public function VerProveedores()
    {
        $con = App::$base;
        $sql = 'SELECT 
            `proveedor`.`id_proveedor`,
            `proveedor`.`Nombre`,
            `proveedor`.`Direccion`,
            `proveedor`.`Telefono`,
            `proveedor`.`Email`,
            `proveedor`.`Nit`,
            `proveedor`.`Descripcion`,
            `proveedor`.`Estado`,
            `proveedor`.`Codigo`
          FROM
            `proveedor`
            Order By Nombre';
        $Res = $con->TablaDatos($sql, array());
        return $Res;
    }

    public function VerMunicipios()
    {
        $con = App::$base;
        $sql = 'SELECT 
            `municipio`.`idmunicipio`,
            `municipio`.`nombreMunicipio`
          FROM
            `municipio`
          ORDER BY
            `municipio`.`nombreMunicipio`';
        $Res = $con->Records($sql, array());
        return $Res;
    }

    public function VerServiciosProveedor($id_proveedor)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `servicios`.`id_servicios`,
                concat(`servicios`.`Nombre`," - $", `servicios`.`Valor` ) as "nombre - precio",
                `servicios`.`Estado`, 
                `servicios`.`Disponibilidad`
                FROM
                 `servicios`
                where 
                `servicios`.`fk_Proveedor`=?
                and
                `servicios`.`Disponibilidad`=?
                order by `servicios`.`id_servicios` DESC';
        $Res = $con->Records($sql, array($id_proveedor, 'S'));
        return $Res;
    }

    public function VerServiciosProveedorSoap($id_proveedor)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `servicios`.`id_servicios`,
                `servicios`.`Nombre`,`servicios`.`Valor`,
                `servicios`.`Estado`, 
                `servicios`.`Disponibilidad`
                FROM
                 `servicios`
                where 
                `servicios`.`fk_Proveedor`=?
                order by `servicios`.`id_servicios` DESC';
        $Res = $con->Records($sql, array($id_proveedor));
        return $Res;
    }

    public function VerServiciosProveedoradmin($id_proveedor)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `servicios`.`id_servicios`,
                concat(`servicios`.`Nombre`," - $", `servicios`.`Valor` ) as "nombre - precio",
                `servicios`.`Estado`, 
                `servicios`.`Disponibilidad`
                FROM
                 `servicios`
                where 
                `servicios`.`fk_Proveedor`=?
                order by `servicios`.`id_servicios` DESC';
        $Res = $con->Records($sql, array($id_proveedor));
        return $Res;
    }

    public function VerPaquetes()
    {
        $con = App::$base;
        $sql = 'SELECT 
            `paquete`.`id_paquete`,
            `paquete`.`Nombre`,
            `paquete`.`Valor`,
            `paquete`.`Fecha_inicio`,
            `paquete`.`Fecha_fin`,
            `paquete`.`Descripcion`,
            `paquete`.`urlFoto`,
            `paquete`.`Disponible`,
            `paquete`.`Estado`
          FROM
            `paquete`
            where `paquete`.`Estado`=?
            
			order by `paquete`.`id_paquete` DESC';
        $Res = $con->Records($sql, array('S'));
        return $Res;
    }

    public function BuscarPaquetes($municipio, $FechaInicion, $FechaFin, $n_pagina, $cantidad_registros_pagina)
    {
        $con    = App::$base;
        $OFFSET = ($cantidad_registros_pagina * $n_pagina) - $cantidad_registros_pagina;
        if ($FechaFin == '')
        {
            $sql   = 'SELECT 
                `paquete`.`id_paquete`,
                `paquete`.`Nombre`,
                `paquete`.`Valor`,
                `paquete`.`Fecha_inicio`,
                concat("<img class=\'img-responsive\' src=\'",`paquete`.`urlFoto`,"\'/>")as "foto",
                `paquete`.`Descripcion`
              FROM
                `paquete`
            LIMIT ? OFFSET ?';
            $datos = array($cantidad_registros_pagina, $OFFSET);
            $Res   = $con->TablaDatos($sql, $datos);
        }
        else
        {
            $sql   = 'SELECT 
                `paquete`.`id_paquete`,
                `paquete`.`Nombre`,
                `paquete`.`Valor`,
                `paquete`.`Fecha_inicio`,
                concat("<img class=\'img-responsive\' src=\'",`paquete`.`urlFoto`,"\'/>")as "foto",
                `paquete`.`Descripcion`
              FROM
                `paquete`
              WHERE
                `paquete`.`Fecha_inicio` BETWEEN ? AND ? AND 
                `paquete`.`Fecha_fin` BETWEEN ? AND ? AND
                `paquete`.`id_Muncipio`=?
                LIMIT ? OFFSET ?';
            $datos = array($FechaInicion, $FechaFin, $FechaInicion, $FechaFin, $municipio, $cantidad_registros_pagina, $OFFSET);
            $Res   = $con->TablaDatos($sql, $datos);
        }
        $count = count($con->Records('SELECT 
                `paquete`.`id_paquete`
              FROM
                `paquete`', array()));
        return array('Datos' => $Res, 'Cantidad' => $count);
    }

    public function VerPaqueteDescripcion($id_paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `paquete`.`id_paquete`,
                `paquete`.`Nombre`,
                `paquete`.`Valor`,
                `paquete`.`Fecha_inicio`,
                `paquete`.`Fecha_fin`,
                `paquete`.`Descripcion`,
                `paquete`.`Disponible`,
                `paquete`.`Estado`,
                `municipio`.`nombreMunicipio`,
                `paquete`.`urlFoto`
              FROM
                `paquete`
                INNER JOIN `municipio` ON (`paquete`.`id_Muncipio` = `municipio`.`idmunicipio`)
            where `paquete`.`id_paquete`=?';
        $Res = $con->Record($sql, array($id_paquete));
        return $Res;
    }

    public function ServiciosXPaquete($Fk_Paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
        `servicios`.`Nombre`,
        `servicios`.`Valor` as "Valor unitario",
        `proveedor`.`Nombre` AS `Nombre_Proveedor`,
        `proveedor`.`Direccion`,
        `proveedor`.`Telefono`,
        `proveedor`.`Email`,
        `servicios_paquete`.`cantidad_servicios`,
        (`servicios_paquete`.`cantidad_servicios` *
        `servicios_paquete`.`valor_unitario_servicio`) as "ValorPaquete"
      FROM
        `proveedor`
        INNER JOIN `servicios` ON (`proveedor`.`id_proveedor` = `servicios`.`fk_Proveedor`)
        INNER JOIN `servicios_paquete` ON (`servicios`.`id_servicios` = `servicios_paquete`.`fk_servicio`)
        where
          `servicios_paquete`.`fk_paquete`=?
        ORDER BY `servicios_paquete`.`id_servicios_paquete` DESC';
        $Res = $con->Records($sql, array($Fk_Paquete));
        return $Res;
    }

    public function Servicios_Paquete($id_servicio_paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
            `paquete`.`Nombre` AS `Paquete`,
            `proveedor`.`Nombre` AS `Proveedor`,
            `servicios`.`Nombre` AS `Servicio`,
            `servicios_paquete`.`valor_unitario_servicio`,
            `servicios_paquete`.`cantidad_servicios`,
            `servicios_paquete`.`porcentaje_admin`
          FROM
            `proveedor`
            INNER JOIN `servicios` ON (`proveedor`.`id_proveedor` = `servicios`.`fk_Proveedor`)
            INNER JOIN `servicios_paquete` ON (`servicios`.`id_servicios` = `servicios_paquete`.`fk_servicio`)
            INNER JOIN `paquete` ON (`servicios_paquete`.`fk_paquete` = `paquete`.`id_paquete`)
          WHERE
            `servicios_paquete`.`id_servicios_paquete` = ?
            and and `servicios`.`Disponibilidad`=?';
        $Res = $con->Record($sql, array($id_servicio_paquete, 'S'));
        return $Res;
    }

    public function ServiciosXPaqueteEdit($Fk_Paquete)
    {
        $con = App::$base;
        $sql = 'SELECT 
        `servicios_paquete`.`id_servicios_paquete` AS `Edit`,
        `servicios_paquete`.`id_servicios_paquete` AS `Delete`,
        `servicios`.`Nombre`,
        `servicios`.`Valor` as "Valor unitario",
        `proveedor`.`Nombre` AS `Nombre_Proveedor`,
        `proveedor`.`Direccion`,
        `proveedor`.`Telefono`,
        `proveedor`.`Email`,
        `servicios_paquete`.`cantidad_servicios`,
        (`servicios_paquete`.`cantidad_servicios` *
        `servicios_paquete`.`valor_unitario_servicio`) as "ValorPaquete"
      FROM
        `proveedor`
        INNER JOIN `servicios` ON (`proveedor`.`id_proveedor` = `servicios`.`fk_Proveedor`)
        INNER JOIN `servicios_paquete` ON (`servicios`.`id_servicios` = `servicios_paquete`.`fk_servicio`)
        where
          `servicios_paquete`.`fk_paquete`=? AND
          `servicios_paquete`.`Disponible`=?
        ORDER BY `servicios_paquete`.`id_servicios_paquete` DESC';
        $Res = $con->Records($sql, array($Fk_Paquete, 'S'));
        return $Res;
    }

    public function ConsultarDisponibilidadServicio($id_servicio)
    {
        $S = atable::Make('servicios');
    }

    public function AutorizarPaquetes($id_Paquete, $Estado)
    {
        $S = atable::Make('paquete');
        $S->Load('id_paquete =' . $id_paquete);
        if (!is_null($S->id_paquete))
        {
            $S->disponibilidad = $Estado;
            $S->Save();
        }
        return $S->id_paquete;
    }

    public function ArmarPaquetes($fk_paquete, $fk_servicio, $cantidad_servicios, $valor_unitario_servicio, $porcentaje_admin)
    {
        $S                          = atable::Make('servicios_paquete');
        $S->fk_paquete              = $fk_paquete;
        $S->fk_servicio             = $fk_servicio;
        $S->valor_unitario_servicio = $valor_unitario_servicio;
        $S->porcentaje_admin        = $porcentaje_admin;
        $S->cantidad_servicios      = $cantidad_servicios;
        $S->disponible              = 'S';
        $S->Save();
        return $S->id_servicios_paquete;
    }

    public function OfertarServicio($FK_paquete, $Nombre, $ValorServicio)
    {
        $S                = atable::Make('servicios');
        $S->fk_paquete    = $FK_paquete;
        $S->nombre        = $Nombre;
        $S->valorServicio = $ValorServicio;
        $S->Save();
        return $S->id_servicios;
    }

    public function OfertarPaquete($Nombre, $Valor, $Fecha_inicio, $Fecha_fin, $Disponible, $Estado, $Descripcion, $urlFoto = '', $id_Muncipio = '')
    {

        $S               = atable::Make('paquete');
        $S->nombre       = $Nombre;
        $S->valor        = $Valor;
        $S->fecha_inicio = $Fecha_inicio;
        $S->fecha_fin    = $Fecha_fin;
        $S->disponible   = $Disponible;
        $S->estado       = $Estado;
        $S->descripcion  = $Descripcion;
        $S->urlfoto      = $urlFoto;
        $S->id_muncipio  = $id_Muncipio;

        $S->Save();
        return $S->id_paquete;
    }

    public function EditarDisponibilidadPaquete($id_paquete, $Disponibilidad)
    {
        $S = atable::Make('paquete');
        $S->Load('id_paquete =' . $id_paquete);
        if (!is_null($S->id_paquete))
        {
            $S->disponibilidad = $Disponibilidad;
            $S->Save();
        }
        return $S->id_paquete;
    }

    public function EditarDisponibilidadServicios($id_servicios, $Disponibilidad)
    {
        $S = atable::Make('servicios');
        $S->Load('id_servicios=' . $id_servicios);
        if (!is_null($S->id_servicios))
        {
            $S->Disponibilidad = $Disponibilidad;
            $S->Save();
        }
        return $S->id_servicios;
    }

    public function QuitarServiciosPaquete($id_servicio_paquete)
    {
        $S = atable::Make('servicios_paquete');
        $S->Load("id_servicios_paquete = $id_servicio_paquete");
        if (!is_null($S->id_servicios_paquete))
        {
            $S->disponible = 'N';
            $S->Save();
        }
        return $S->id_servicios_paquete;
    }

    public function EditarServiciosPaquete($id_servicios_paquete, $cantidad_servicios, $valor_unitario_servicio, $porcentaje_admin)
    {
        $S = atable::Make('servicios_paquete');
        $S->Load("id_servicios_paquete =$id_servicios_paquete");
        if (!is_null($S->id_servicios_paquete))
        {
            $S->cantidad_servicios      = $cantidad_servicios;
            $S->valor_unitario_servicio = $valor_unitario_servicio;
            $S->porcentaje_admin        = $porcentaje_admin;
            $S->Save();
        }
        return $S->id_servicios_paquete;
    }

    public function NuevoServicio($Nombre, $fk_Proveedor, $Valor, $Estado = 'S', $Disponibilidad = 'N')
    {
        $S                 = atable::Make('servicios');
        $S->nombre         = $Nombre;
        $S->fk_proveedor   = $fk_Proveedor;
        $S->valor          = $Valor;
        $S->estado         = $Estado;
        $S->disponibilidad = $Disponibilidad;
        $S->Save();
        return $S->id_servicios;
    }

}
