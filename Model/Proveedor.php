<?php

include_once './BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class Proveedor
{

    private $con;

    public function __construct()
    {
        $this->con = App::$base;
    }

    public function VerProveedor($Id_proveedor)
    {
        $P     = atable::Make('proveedor');
        $P->load("`id_proveedor` = '$Id_proveedor'");
        $Datos = array();
        $Datos['Nombre'] = $P->nombre;
        $Datos['Telefono'] = $P->telefono;
        $Datos['Email'] = $P->email;
        $Datos['Nit'] = $P->nit;
        $Datos['Estado'] = $P->estado;
        return $Datos;
    }
}
$X=new Proveedor();
print_r($X->VerProveedor(1));
