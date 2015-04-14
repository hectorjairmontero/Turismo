<?php

include_once '../Model/ModelProveedor.php';

class Proveedor
{

    public function VerProveedores()
    {
        $Res = new ModelProveedor();
        $Datos = $Res->VerProveedores();
        return $Datos;
    }
    private function CodigoProveedor($id_proveedor)
    {
        $letra     = 'PSIIT';
        $digitos   = 7;
        $cant      = (int) $id_proveedor;
        $nletra    = strlen($letra);
        $ncant     = strlen($cant);
        $str_ceros = '';
        $ceros     = $digitos - $nletra + $ncant; // cantidad de ceros para adicionar
        for ($i = 1; $i <= $ceros; $i++)
        {
            $str_ceros .= "0";
        }
        $cant++;
        $codigo = $letra . $str_ceros . $cant;

        return $codigo;
    }
    public function RegistrarProveedor($Nombre, $Telefono, $Email, $Nit)
    {
        $Registrar    = new ModelProveedor();
        $id_proveedor = $Registrar->RegistrarProveedor($Nombre, $Telefono, $Email, $Nit);
        $Codigo       = $this->CodigoProveedor($id_proveedor);
        $Registrar->RegistrarCodigoProveedor($id_proveedor, $Codigo);
        return $Codigo;
    }

    public function BuscarProveedor($id_proveedor)
    {
        $Ver = new ModelProveedor();
        $Datos=$Ver->VerProveedor($id_proveedor);
        return $Datos;
    }
    public function InfoProveedor($Cod_proveedor)
    {
        $Ver = new ModelProveedor();
        $Datos=$Ver->VerProveedorCod($Cod_proveedor);
        return $Datos; 
    }
    private function Total($Datos)
    {
        $Total=0;
        foreach ($Datos as $Temp)
        {
            $Total=$Total+$Temp['valor_neto'];
        }
        return $Total;
    }
    public function EstadoCuentaTotal($Cod_proveedor,$FechaIncial,$FechaFinal)
    {
        $Ver = new ModelProveedor();
        $Datos=$Ver->EstadoCuentaTotal($Cod_proveedor,$FechaIncial,$FechaFinal);
        $Res=array('Datos'=>$Datos,'Total'=>  $this->Total($Datos));
        return $Res;
    }
    public function EstadoCuentaPaquete($Cod_proveedor,$FechaIncial,$FechaFinal,$id_paquete)
    {
        $Ver = new ModelProveedor();
        $Datos=$Ver->EstadoCuentaPaquete($Cod_proveedor,$FechaIncial,$FechaFinal,$id_paquete);
        return $Datos;
    }

}
