<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelServicios
{

    public function VerPaquetes()
    {
        $con = App::$base;
        $sql='SELECT 
            `paquete`.`id_paquete`,
            `paquete`.`Nombre`,
            `paquete`.`Valor`,
            `paquete`.`Fecha_inicio`,
            `paquete`.`Fecha_fin`,
            `paquete`.`Disponible`,
            `paquete`.`Estado`
          FROM
            `paquete`
            where `paquete`.`Estado`=?';
        $Res=$con->Records($sql,array('S'));
        return $Res;
    }
    public function ServiciosXPaquete($Fk_Paquete)
    {
        $con = App::$base;
        $sql='SELECT 
        `servicios`.`Nombre`,
        `servicios`.`Valor`,
        `servicios`.`Disponibilidad`,
        `proveedor`.`Nombre` AS `Nombre_Proveedor`,
        `proveedor`.`Telefono`,
        `proveedor`.`Email`
      FROM
        `proveedor`
        INNER JOIN `servicios` ON (`proveedor`.`id_proveedor` = `servicios`.`fk_Proveedor`)
        INNER JOIN `servicios_paquete` ON (`servicios`.`id_servicios` = `servicios_paquete`.`fk_servicio`)
        where
          `servicios_paquete`.`fk_paquete`=';
        $Res=$con->Records($sql,array($Fk_Paquete));
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

    public function ArmarPaquetes($fk_paquete, $fk_servicio, $cantidad_servicios)
    {
        $S                     = atable::Make('servicios_paquete');
        $S->fk_paquete         = $fk_paquete;
        $S->fk_servicio        = $fk_servicio;
        $S->cantidad_servicios = $cantidad_servicios;
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

    public function VerServicioDisponible($id_servicio, $proveedor)
    {
        
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

}