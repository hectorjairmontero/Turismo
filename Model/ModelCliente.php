<?php
include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';
class ModelCliente
{
    public function RegistrarClientes($Nombres, $Apellidos, $TipoID, $Numero_Id, $Email)
    {
        $C = atable::Make('cliente');
        $C->nombres=$Nombres;
        $C->apellidos=$Apellidos;
        $C->tipoid=$TipoID;
        $C->numero_id=$Numero_Id;
        $C->email=$Email;
        $C->Save();
        return $C->id_cliente;
    }

}