<?php

include_once './DatosServicios.php';

class Servicios
{

    private $Con;

    public function __construct()
    {
        $this->Con = new DatosServicios();
    }

    private function Datos($year, $Indicador, $Datos)
    {
        foreach ($Datos as $Value)
        {
            if (($Value['Variables']['cod'] == $Indicador) && ($Value['categoria']['Nombre'] == $year))
            {
                $Val = $Value['valor'];
                if (is_null($Val))
                {
                    $Val = '-';
                }
                return $Val;
            }
        }
    }
    private function indicador($Datos,$id)
    {
        foreach ($Datos as $Value)
        {
            if ($Value['Variables']['cod'] == $id)
            {
                return $Value['Variables']['Nombre'] ;
            }
        }
    }
    private function ValoresIndicadoresYear($year, $Indicador, $Datos, $Cabecera)
    {
        $Res = '<table class="classTable" border=1>';
        if ($Cabecera == '')
        {
            $$Cabecera='indicador';
        }
        $Res.='<td>' . $Cabecera . '/año</td>';
        for ($j = 0; $j < count($year); $j++)
        {
            $Res.='<td>' . ($year[$j]) . '</td>';
        }
        for ($i = 0; $i < count($Indicador); $i++)
        {
            $Res.='<tr>';
            $Res.='<td>' .$this->indicador($Datos,$Indicador[$i]) . '</td>';
            for ($j = 0; $j < count($year); $j++)
            {
                $Res.='<td>' . $this->Datos($year[$j], $Indicador[$i], $Datos) . '</td>';
            }
            $Res.='</tr>';
        }
        $Res.= '</table>';
        return $Res;
    }

    private function Html($Res)
    {
        foreach ($Res[1] as $value)
        {
            $year[] = $value['categoria']['Nombre'];
        }
        foreach ($Res[1] as $Variables)
        {
            $indicadores[] = $Variables['Variables']['cod'];
        }

        $year        = array_unique($year);
        $Temp = array_unique($indicadores);
        $indicadores='';
        foreach($Temp as $temp)
        {
            $indicadores[]=$temp;
        }
        $Cabecera = $Res[0]['Cabecera'];
        $Values   = $this->ValoresIndicadoresYear($year, $indicadores, $Res[1], $Cabecera);
        $Datos    = array(
            'Dimension' => $Res[0]['Dimension']['Nombre'],
            'Tematica'  => $Res[0]['Tematica']['Nombre'],
            'Indicador' => $Res[0]['Indicador']['Nombre'],
            'Municipio' => $Res[0]['Municipio']['Nombre'],
            'Fuente'    => $Res[0]['Fuente'],
            'Tabla'     => $Values
                );
        return $Datos;
    }

    public function DimensionesTematicasCategorias()
    {
        $Res = $this->Con->DimensionesTematicasCategorias();
        return json_encode($Res);
    }

    public function DatosTangaraHTML($id_indicador, $Municipio)
    {
        $Res  = $this->Con->Datos($id_indicador, $Municipio);
        $html = $this->Html($Res);
        return json_encode($html);
    }

    public function DatosTangara($id_indicador, $Municipio)
    {
        $Res = $this->Con->Datos($id_indicador, $Municipio);
        return json_encode($Res);
    }

    public function Municipios()
    {
        $Res = $this->Con->Municipios();
        return json_encode($Res);
    }

    public function Indicadores()
    {
        $Res = $this->Con->Indicador();
        return json_encode($Res);
    }

}
