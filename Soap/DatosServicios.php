<?php

include_once '../BaseDatos/conexion.php';

class DatosServicios
{

    public function DimensionesTematicasCategorias()
    {
        $db    = App::$base;
        $sql   = "SELECT 
                `dimension`.`id_dimension` as 'cod_dimension',
                `dimension`.`Descripcion` as 'Nombre_dimension',
                `tematica`.`id_tematica` as 'cod_tematica',
                `tematica`.`Descripcion`as 'Nombre_tematica',
                `indicadores`.`id_indicadores` as 'cod_indicador',
                `indicadores`.`Nombre` as 'Nombre_indicador'
              FROM
                `tematica`
                INNER JOIN `dimension` ON (`tematica`.`fk_Dimension` = `dimension`.`id_dimension`)
                INNER JOIN `indicadores` ON (`tematica`.`id_tematica` = `indicadores`.`fk_tematica`)";
        $res   = $db->dosql($sql, array());
        $Datos = array();
        while (!$res->EOF)
        {
            $Datos[] = $res->fields;
            $res->MoveNext();
        }
        return $Datos;
    }

    public function Municipios()
    {
        $db    = App::$base;
        $sql   = "SELECT 
                `municipio`.`idmunicipio`,
                `municipio`.`nombreMunicipio`
              FROM
                `municipio`
              ORDER BY
                `municipio`.`nombreMunicipio`";
        $res   = $db->dosql($sql, array());
        $Datos = array();
        while (!$res->EOF)
        {
            $Datos[] = array($res->fields['idmunicipio'], $res->fields['nombreMunicipio']);
            $res->MoveNext();
        }
        return $Datos;
    }

    public function Indicador()
    {
        $db    = App::$base;
        $sql   = "SELECT 
            `indicadores`.`id_indicadores`,
            `indicadores`.`Nombre`
          FROM
            `indicadores`
            order by Nombre";
        $res   = $db->dosql($sql, array());
        $Datos = array();
        while (!$res->EOF)
        {
            $Datos[] = array($res->fields['id_indicadores'], $res->fields['Nombre']);
            $res->MoveNext();
        }
        return $Datos;
    }

    private function DatosIndicador($id_indicador, $Municipio)
    {
        $db    = App::$base;
        $sql   = "SELECT 
            `dimension`.`id_dimension` AS `dimension_cod`,
            `dimension`.`Descripcion` AS `dimension_Nombre`,
            `tematica`.`id_tematica` AS `tematica_cod`,
            `tematica`.`Descripcion` AS `tematica_Nombre`,
            `municipio`.`idmunicipio` AS `municipio_cod`,
            `municipio`.`nombreMunicipio` AS `municipio_Nombre`,
            `indicadores`.`id_indicadores` AS `indicadores_cod`,
            `indicadores`.`Nombre` as `indicadores_Nombre`,
            `indicadores`.`Descripcion` AS `Cabecera`,
            `fuente`.`texto_fuente` AS `Fuente`
          FROM
            `indicadores`
            INNER JOIN `fuente` ON (`indicadores`.`id_indicadores` = `fuente`.`id_indicador`)
            INNER JOIN `municipio` ON (`fuente`.`id_municipio` = `municipio`.`idmunicipio`)
            INNER JOIN `tematica` ON (`indicadores`.`fk_tematica` = `tematica`.`id_tematica`)
            INNER JOIN `dimension` ON (`tematica`.`fk_Dimension` = `dimension`.`id_dimension`)
          WHERE
            `indicadores`.`id_indicadores` =? AND 
            `municipio`.`idmunicipio`=?";
        $res   = $db->dosql($sql, array($id_indicador, $Municipio));
        $Datos = array();
        while (!$res->EOF)
        {
            $Datos['Dimension']['cod']    = $res->fields['dimension_cod'];
            $Datos['Dimension']['Nombre'] = $res->fields['dimension_Nombre'];
            $Datos['Tematica']['cod']     = $res->fields['tematica_cod'];
            $Datos['Tematica']['Nombre']  = $res->fields['tematica_Nombre'];
            $Datos['Municipio']['cod']    = $res->fields['municipio_cod'];
            $Datos['Municipio']['Nombre'] = $res->fields['municipio_Nombre'];
            $Datos['Indicador']['cod']    = $res->fields['indicadores_cod'];
            $Datos['Indicador']['Nombre'] = $res->fields['indicadores_Nombre'];
            $Datos['Cabecera']            = $res->fields['Cabecera'];
            $Datos['Fuente']              = $res->fields['Fuente'];

            $res->MoveNext();
        }
        return $Datos;
    }

    private function Variables($id_indicador, $Municipio)
    {
        
    }

    private function Registros($id_indicador, $Municipio)
    {
        $db    = App::$base;
        $sql   = "SELECT 
                `categoria`.`id_categoria`,
                `categoria`.`Nombre`,
                `datos`.`id_variable`,
                `variables`.`descripcion`,
                `datos`.`Valor`
              FROM
                `datos`
                INNER JOIN `variables` ON (`datos`.`id_variable` = `variables`.`id_variable`)
                INNER JOIN `categoria` ON (`datos`.`id_categoria` = `categoria`.`id_categoria`)
              WHERE
                `datos`.`id_municipio` = ? AND 
                `variables`.`id_indicador` = ?";
        $res   = $db->dosql($sql, array($Municipio, $id_indicador));
        $Datos = array();
        while (!$res->EOF)
        {
            $Temp['categoria']['cod']    = $res->fields['id_categoria'];
            $Temp['categoria']['Nombre'] = $res->fields['Nombre'];
            $Temp['Variables']['cod']    = $res->fields['id_variable'];
            $Temp['Variables']['Nombre'] = $res->fields['descripcion'];
            $Temp['valor']               = $res->fields['Valor'];
            $res->MoveNext();
            $Datos[]                     = $Temp;
        }
        return $Datos;
    }

    public function Datos($id_indicador, $Municipio)
    {
        $Datos     = $this->DatosIndicador($id_indicador, $Municipio);
        $Registros = $this->Registros($id_indicador, $Municipio);
        $Valores   = array($Datos, $Registros);
        return $Valores;
    }

}
