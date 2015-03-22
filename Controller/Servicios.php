<?php

include_once '../Model/ModelServicios.php';

class Servicios
{

    public function VerPaquetes()
    {
        $Paquete = new ModelServicios();
        $Datos=$Paquete->VerPaquetes();
        return $Datos;
    }
    public function ServiciosXPaquete($id_paquete)
    {
        $Servicio = new ModelServicios();
        $Datos = $Servicio->ServiciosXPaquete($id_paquete);
        return $Datos;
    }
    public function VerPaquetesConServicios()
    {
        $Paquetes=  $this->VerPaquetes();
        $Res=array();
        foreach ($Paquetes as $Temp)
        {
            $Res=$Temp;
            $Res['Servicios']=  $this->ServiciosXPaquete($Temp['id_paquete']);
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

    public function SiValidaPaquete($id_paquete)
    {
        
    }

    public function SiValidaServicio($id_servicio)
    {
        
    }

    public function ConsultarDisponibilidadPaquete($id_paquete)
    {
        
    }

    public function ConsultarDisponibilidadServicio($id_servicio)
    {
        $Servicio = new ModelServicios();
        $Datos=$Servicio->ConsultarDisponibilidadServicio($id_servicio);
        return $Datos;
    }

    public function ArmarPaquetes($id_paquete, $id_servicio, $cantidad_servicios)
    {
        $Armar = new ModelServicios();
        $Armar->ArmarPaquetes($fk_paquete, $fk_servicio, $cantidad_servicios);
    }

    public function AutorizarPaquetes($id_Paquete, $Estado)
    {
        $auto = new ModelServicios();
        $auto->AutorizarPaquetes($id_Paquete, $Estado);
    }
    
}