<?php
include_once './Proveedor.php';
class Servicios
{

    private $Proveedor;

    public function __construct($id_Proveedor)
    {
       $DatosProveedor=new Proveedor();
       $this->Proveedor=  $DatosProveedor->BuscarProveedor($id_Proveedor);
    }

    public function VerServicioDisponible($id_servicio)
    {
        
    }
    public function NuevoPaquete($Nombre,$Valor,$Fecha_inicio,$Fecha_fin,$Disponible,$Estado)
    {
        
    }
    public function NuevoServicio($FK_paquete,$Nombre,$ValorServicio,$cantidad,$Fk_paquete)
    {
        
    }
    public function ConfirmarDisponibilidad($id_paquete)
    {
        
    }
}
