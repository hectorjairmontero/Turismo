<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelServicios
{
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
        }
        return $S->id_servicios;
    }

}
