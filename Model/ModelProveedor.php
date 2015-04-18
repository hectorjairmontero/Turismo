<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelProveedor
{

    private $con;

    public function __construct()
    {
        $this->con = App::$base;
    }

    public function Retirar_Proveedor($id_Proveedor)
    {
        $P         = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_Proveedor'");
        $P->estado = 'N';
        $P->Save();
    }

    public function RegistrarProveedor($Nombre, $Telefono, $Email, $Nit, $Direccion, $Descripcion)
    {
        $P              = atable::Make('proveedor');
        $P->nombre      = $Nombre;
        $P->telefono    = $Telefono;
        $P->email       = $Email;
        $P->nit         = $Nit;
        $P->direccion   = $Direccion;
        $P->descripcion = $Descripcion;
        $P->estado      = 'A';
        $P->Save();
        return $P->id_proveedor;
    }

    public function ActualizarProveedor($id_Proveedor, $Nombre, $Telefono, $Email, $Nit, $Direccion, $Descripcion)
    {
        $P              = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_Proveedor'");
        $P->nombre      = $Nombre;
        $P->telefono    = $Telefono;
        $P->email       = $Email;
        $P->nit         = $Nit;
        $P->direccion   = $Direccion;
        $P->descripcion = $Descripcion;
        $P->Save();
        return $P->id_proveedor;
    }

    public function EstadoCuentaTotal($Cod_proveedor, $FechaIncial, $FechaFinal)
    {
        $sql = 'SELECT 
                (`servicios_paquete`.`cantidad_servicios` * `servicios_paquete`.`valor_unitario_servicio` * (100 - `servicios_paquete`.`porcentaje_admin`) / 100) AS `ganancia`,
                `servicios_paquete`.`valor_unitario_servicio`,
                (`servicios_paquete`.`valor_unitario_servicio` * (100 - `servicios_paquete`.`porcentaje_admin`) / 100) AS `valor_neto`,
                `servicios_paquete`.`cantidad_servicios`,
                `servicios`.`Nombre` AS `servicio`,
                concat(FORMAT(`servicios_paquete`.`porcentaje_admin`,2)) as "porcentaje_admin",
                `paquete`.`Nombre` AS `paquete`
              FROM
                `paquete`
                INNER JOIN `servicios_paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
                INNER JOIN `servicios` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `reserva` ON (`paquete`.`id_paquete` = `reserva`.`Fk_paquete`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
              WHERE
                `reserva`.`Fecha_reserva` BETWEEN ? AND ? AND 
                `proveedor`.`Codigo`=?';
        $Res = $this->con->Records($sql, array($FechaIncial, $FechaFinal, $Cod_proveedor));
        return $Res;
    }

    public function EstadoCuentaPaquete($Cod_proveedor, $FechaIncial, $FechaFinal, $id_paquete)
    {
        $sql = 'SELECT 
                (`servicios_paquete`.`cantidad_servicios` * `servicios_paquete`.`valor_unitario_servicio` * (100 - `servicios_paquete`.`porcentaje_admin`) / 100) AS `ganancia`,
                `servicios_paquete`.`valor_unitario_servicio`,
                (`servicios_paquete`.`valor_unitario_servicio` * (100 - `servicios_paquete`.`porcentaje_admin`) / 100) AS `valor_neto`,
                `servicios_paquete`.`cantidad_servicios`,
                `servicios`.`Nombre` AS `servicio`,
                `paquete`.`Nombre` AS `paquete`
              FROM
                `paquete`
                INNER JOIN `servicios_paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
                INNER JOIN `servicios` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `reserva` ON (`paquete`.`id_paquete` = `reserva`.`Fk_paquete`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
              WHERE
                `proveedor`.`Codigo`=? and  
                `reserva`.`Fecha_reserva` BETWEEN ? AND ? 
                AND `paquete`.`id_paquete`=?';
        $Res = $this->con->Records($sql, array($Cod_proveedor, $FechaIncial, $FechaFinal, $id_paquete));
        return $Res;
    }

    public function RegistrarCodigoProveedor($id_proveedor, $Codigo)
    {
        $P         = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_proveedor'");
        $P->codigo = $Codigo;
        $P->Save();
    }

    public function VerProveedor($id_proveedor)
    {
        $P                    = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_proveedor'");
        $Datos                = array();
        $Datos['Nombre']      = $P->nombre;
        $Datos['Telefono']    = $P->telefono;
        $Datos['Direccion']   = $P->direccion;
        $Datos['Email']       = $P->email;
        $Datos['Nit']         = $P->nit;
        $Datos['Estado']      = $P->estado;
        $Datos['Codigo']      = $P->codigo;
        $Datos['Descripcion'] = $P->descripcion;
        return $Datos;
    }

    public function VerProveedorCod($codigo)
    {
        $P                     = atable::Make('proveedor');
        $P->load("codigo = '$codigo'");
        $Datos                 = array();
        $Datos['id_proveedor'] = $P->id_proveedor;
        $Datos['Nombre']       = $P->nombre;
        $Datos['Telefono']     = $P->telefono;
        $Datos['Email']        = $P->email;
        $Datos['Nit']          = $P->nit;
        $Datos['Estado']       = $P->estado;
        $Datos['Codigo']       = $P->codigo;
        return $Datos;
    }

    public function VerProveedores()
    {
        $sql = 'SELECT 
            `proveedor`.`id_proveedor`,
            `proveedor`.`Nombre`,
            `proveedor`.`Telefono`,
            `proveedor`.`Email`,
            `proveedor`.`Nit`,
            `proveedor`.`Estado`,
            `proveedor`.`Codigo`,
            `proveedor`.`Descripcion`
          FROM
            `proveedor`';
        $Res = $this->con->Records($sql, array());
        return $Res;
    }

    public function RegistrosVentasServicios($FechaInicio, $FechaFin, $Cod_proveedor)
    {
        $sql = 'SELECT 
                count(`servicios`.`id_servicios`) AS `cantidad`,
                `servicios`.`Nombre`,
                `proveedor`.`Nombre` AS `proveedor`,
                `proveedor`.`Nit`
              FROM
                `reserva`
                INNER JOIN `paquete` ON (`reserva`.`Fk_paquete` = `paquete`.`id_paquete`)
                INNER JOIN `servicios_paquete` ON (`paquete`.`id_paquete` = `servicios_paquete`.`fk_paquete`)
                INNER JOIN `servicios` ON (`servicios_paquete`.`fk_servicio` = `servicios`.`id_servicios`)
                INNER JOIN `proveedor` ON (`servicios`.`fk_Proveedor` = `proveedor`.`id_proveedor`)
              WHERE
                `reserva`.`Estado` = "Confirmado" AND 
                `reserva`.`Fecha_reserva` BETWEEN ? AND ? AND
                  `proveedor`.`Codigo`=?
              GROUP BY
            `servicios`.`Nombre`,
            `proveedor`.`Nit`';
        $Res = $this->con->Records($sql, array($FechaInicio, $FechaFin, $Cod_proveedor));
        return $Res;
    }

}
