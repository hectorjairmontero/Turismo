<?php

include_once '../Model/ModelServicios.php';

class Servicios
{

    public function VerPaquetes()
    {
        $Paquete = new ModelServicios();
        $Datos   = $Paquete->VerPaquetes();
        return $Datos;
    }

    public function VerDescripcionPaquete($id_paquete)
    {
        $Paquete = new ModelServicios();
        $Datos   = $Paquete->VerPaqueteDescripcion($id_paquete);
        return $Datos;
    }

    public function VerServiciosProveedor($id_proveedor)
    {
        $Paquete = new ModelServicios();
        $Datos   = $Paquete->VerServiciosProveedor($id_proveedor);
        return $Datos;
    }

    public function ServiciosXPaquete($id_paquete)
    {
        $Servicio = new ModelServicios();
        $Datos    = $Servicio->ServiciosXPaquete($id_paquete);
        return $Datos;
    }

    public function VerPaquetesConServicios()
    {
        $Paquetes = $this->VerPaquetes();
        $Res      = array();
        foreach ($Paquetes as $Temp)
        {
            $Res[] = array('Paquete' => $Temp, 'Servicios' => $this->ServiciosXPaquete($Temp['id_paquete']));
        }
        return $Res;
    }

    public function OfertarPaquete($Nombre, $Valor, $Fecha_inicio, $Fecha_fin, $Disponible, $Estado)
    {
        $Ofertar = new ModelServicios();
        $id      = $Ofertar->OfertarPaquete($Nombre, $Valor, $Fecha_inicio, $Fecha_fin, $Disponible, $Estado);
        return $id;
    }

    public function OfertarServicio($FK_paquete, $Nombre, $ValorServicio)
    {
        $Ofertar = new ModelServicios();
        $id      = $Ofertar->OfertarServicio($FK_paquete, $Nombre, $ValorServicio);
        return $Ofertar->$id;
    }

    public function EditarDisponibilidadPaquete($id_paquete, $Disponibilidad)
    {
        $Disponible = new ModelServicios();
        $Disponible->EditarDisponibilidadPaquete($id_paquete, $Disponibilidad);
    }

    public function EditarDisponibilidadServicios($id_servicios, $Disponibilidad)
    {
        $Disponible = new ModelServicios();
        $Disponible->EditarDisponibilidadServicios($id_servicios, $Disponibilidad);
    }

    public function ConsultarDisponibilidadServicio($id_servicio)
    {
        $Servicio = new ModelServicios();
        $Datos    = $Servicio->ConsultarDisponibilidadServicio($id_servicio);
        return $Datos;
    }

    public function ArmarPaquetes($id_paquete, $id_servicio, $cantidad_servicios, $valor_unitario_servicio, $porcentaje_admin)
    {
        $Armar = new ModelServicios();
        $id    = $Armar->ArmarPaquetes($id_paquete, $id_servicio, $cantidad_servicios, $valor_unitario_servicio, $porcentaje_admin);
        return $id;
    }

    public function AutorizarPaquetes($id_Paquete, $Estado)
    {
        $auto = new ModelServicios();
        return $auto->AutorizarPaquetes($id_Paquete, $Estado);
    }

    public function QuitarServiciosPaquete($id_servicio_paquete)
    {
        $auto = new ModelServicios();
        return $auto->QuitarServiciosPaquete($id_servicio_paquete);
    }

    public function EditarServiciosPaquete($fk_paquete, $fk_servicio, $cantidad_servicios, $valor_unitario_servicio, $porcentaje_admin)
    {
        $auto = new ModelServicios();
        return $auto->QuitarServiciosPaquete($id_paquete, $id_servicio);
    }

    public function VerServiciosEditDelete($id_Paquete)//Administrador
    {
        $Render = new Visual();
        $edit   = new ModelServicios();
        $Datos  = $edit->ServiciosXPaqueteEdit($id_Paquete);
        $Res    = array();
        foreach ($Datos as $Temp)
        {
            $Temp['Edit']   = $Render->GenerardorLink('', 'Editar(' . $Temp['Edit'] . ')', '../images/lapiz.png');
            $Temp['Delete'] = $Render->GenerardorLink('', 'Eliminar(' . $Temp['Delete'] . ')', '../images/recycle.png');
            $Res[]          = $Temp;
        }
        return ($Res);
    }

}