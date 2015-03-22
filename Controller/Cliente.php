<?php
include_once '../Model/ModelCliente.php';
class Cliente
{
    public function RegistrarClientes($Nombres,$Apellidos,$TipoID,$Numero_Id,$Email)
    {
        $Registro=new ModelCliente();
        $id=$Registro->RegistrarClientes($Nombres, $Apellidos, $TipoID, $Numero_Id, $Email);
        return $id;
    }
    
}
