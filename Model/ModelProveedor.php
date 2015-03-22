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

    public function RegistrarProveedor($Nombre, $Telefono, $Email, $Nit)
    {
        $P = atable::Make('proveedor');
        $P->nombre=$Nombre;
        $P->telefono=$Telefono;
        $P->email=$Email;
        $P->nit=$Nit;
        $P->Save();
        return $P->id_proveedor;
    }

    public function RegistrarCodigoProveedor($id_proveedor, $Codigo)
    {
        $P = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_proveedor'");
        $P->codigo=$Codigo;
        $P->Save();
    }

    public function VerProveedor($id_proveedor)
    {
        $P                 = atable::Make('proveedor');
        $P->load("id_proveedor = '$id_proveedor'");
        $Datos             = array();
        $Datos['Nombre']   = $P->nombre;
        $Datos['Telefono'] = $P->telefono;
        $Datos['Email']    = $P->email;
        $Datos['Nit']      = $P->nit;
        $Datos['Estado']   = $P->estado;
        $Datos['Codigo']   = $P->codigo;
        return $Datos;
    }
    public function VerProveedores()
    {
        $sql='SELECT 
            `proveedor`.`id_proveedor`,
            `proveedor`.`Nombre`,
            `proveedor`.`Telefono`,
            `proveedor`.`Email`,
            `proveedor`.`Nit`,
            `proveedor`.`Estado`,
            `proveedor`.`Codigo`
          FROM
            `proveedor`';
        $Res=$this->con->Records($sql,array());
        return $Res;
        
    }
}
