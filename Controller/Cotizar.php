<?php

include_once '../Model/ModelCotizar.php';

class Cotizar
{

    public function ActualizarCotizaciones($Datos)
    {
        $Cotizacion = new ModelCotizar();
        foreach ($Datos['ids'] as $Temp)
        {   
            $cant=($Datos['cantidad'][$Temp]);
            $Valor=($Datos['Valor'][$Temp]);
            $Res = $Cotizacion->ActualizarDetalleCotizacion($Temp, $cant, $Valor);
        }
        $Cotizacion->actualizarEstadoCotizacion($Res);
    }

    public function VerCabCotizacion()
    {
        $Cotizacion = new ModelCotizar();
        $Res        = $Cotizacion->VerCabCotizacion();
        return $Res;
    }

    public function Total($idcotizacion)
    {
        $Cotizacion = new ModelCotizar();
        $Total      = $Cotizacion->TotalCotizacion($idcotizacion);
        return $Total['Total'];
    }

    public function actualizarPrecio($idcotizacion)
    {
        $Cotizacion = new ModelCotizar();
        $Total      = $this->Total($idcotizacion);
        $Cotizacion->ActualizarPrecio($idcotizacion, $Total);
    }

    public function CabCotizacion($FechaInicio, $descripcion_cotizacion, $codusuario, $FechaActual = '')
    {
        $Cab = new ModelCotizar();
        $id  = $Cab->CabCotizacion($FechaInicio, $descripcion_cotizacion, $codusuario, $FechaActual);
        return $id;
    }

    public function DetalleCotizacion($id_servicio, $cantidad, $id_cotizacion)
    {
        $Cab = new ModelCotizar();
        $id  = $Cab->DetalleCotizacion($id_servicio, $cantidad, $id_cotizacion);
        $this->actualizarPrecio($id);
        return $id;
    }

    public function VerCotizacionEdit($id_cotizacion)
    {
        $Datos = new ModelCotizar();
        $Res   = $Datos->VerCotizacionEdit($id_cotizacion);
        return $Res;
    }

    public function VerCotizacion($id_cotizacion)
    {
        $Datos = new ModelCotizar();
        $Res   = $Datos->VerCotizacion($id_cotizacion);
        return $Res;
    }

}
