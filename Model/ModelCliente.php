<?php

include_once 'BaseDatos/conexion.php';
include_once Config::$home_bin . Config::$ds . 'db' . Config::$ds . 'active_table.php';

class ModelCliente
{

    public function RegistrarClientes($Nombres, $Apellidos, $TipoID, $Numero_Id, $Email,$Telefono)
    {
        $C            = atable::Make('cliente');
        $C->nombres   = $Nombres;
        $C->apellidos = $Apellidos;
        $C->tipoid    = $TipoID;
        $C->numero_id = $Numero_Id;
        $C->email     = $Email;
        $C->telefono     = $Telefono;
        $C->Save();
        return $C->id_cliente;
    }

    public function buscarusuariodocumento($Documento)
    {
        $Datos=NULL;
        $C = atable::Make('cliente');
        $C->Load("numero_id = $Documento");
        if (!is_null($C->id_cliente))
        {
            $Datos['id_cliente']=$C->id_cliente;
            $Datos['nombres']=$C->nombres;
            $Datos['apellidos']=$C->apellidos;
            $Datos['tipoid']=$C->tipoid;
            $Datos['numero_id']=$C->numero_id;
            $Datos['email']=$C->email;
        }
        return $Datos;
    }

}
