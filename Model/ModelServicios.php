<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelServicios
{

    public function VerServiciosProveedor($id_proveedor)
    {
        $con = App::$base;
        $sql = 'SELECT 
                `servicios`.`id_servicios`,
                `servicios`.`Nombre`,
                `servicios`.`Valor`,
                `servicios`.`Estado`,
                `servicios`.`Disponibilidad`
              FROM
                `servicios`
                where 
                `servicios`.`fk_Proveedor`=?';
        $Res = $con->TablaDatos($sql, array($id_proveedor));
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
            `paquete`.`Disponible`,
            `paquete`.`Estado`
          FROM
            `paquete`
            where `paquete`.`Estado`=?';
        $Res = $con->Records($sql, array('S'));
        return $Res;
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
            `paquete`.`Estado`
          FROM
            `paquete`
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
        `servicios`.`Disponibilidad`,
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
        ORDER BY `servicios_paquete`.`id_servicios_paquete`';
        $Res = $con->Records($sql, array($Fk_Paquete));
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

    public function ArmarPaquetes($fk_paquete, $fk_servicio, $cantidad_servicios, $valor_unitario_servicio,$porcentaje_admin)
    {
        $S                          = atable::Make('servicios_paquete');
        $S->fk_paquete              = $fk_paquete;
        $S->fk_servicio             = $fk_servicio;
        $S->valor_unitario_servicio = $valor_unitario_servicio;
        $S->porcentaje_admin        = $porcentaje_admin;
        $S->cantidad_servicios      = $cantidad_servicios;
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
    public function OfertarPaquete($Nombre, $Valor, $Fecha_inicio, $Fecha_fin, $Disponible, $Estado)
    {
        $S               = atable::Make('paquete');
        $S->nombre       = $Nombre;
        $S->valor        = $Valor;
        $S->fecha_fin    = $Fecha_fin;
        $S->fecha_inicio = $Fecha_inicio;
        $S->disponible   = $Disponible;
        $S->estado       = $Estado;
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
    public function QuitarServiciosPaquete($fk_paquete,$fk_servicio)
    {
        $S = atable::Make('servicios');
        $S->Load("fk_paquete =$fk_paquete and fk_servicio=$fk_servicio");
        if (!is_null($S->id_servicios))
        {
            $S->disponible = 'N';
            $S->Save();
        }
        return $S->id_servicios;
    }
    public function EditarServiciosPaquete($fk_paquete,$fk_servicio,$cantidad_servicios,$valor_unitario_servicio,$porcentaje_admin)
    {
        $S = atable::Make('servicios');
        $S->Load("fk_paquete =$fk_paquete and fk_servicio=$fk_servicio");
        if (!is_null($S->id_servicios))
        {
            $S->cantidad_servicios = $cantidad_servicios;
            $S->valor_unitario_servicio = $valor_unitario_servicio;
            $S->porcentaje_admin = $porcentaje_admin;
            $S->Save();
        }
        return $S->id_servicios;
    }
}
