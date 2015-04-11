<?php

include_once '../Controller/Nusoap/nusoap.php';

class WebService
{

    private $Con;
    public $GetError;

    public function __construct()
    {
        $URL       = 'http://localhost/Turismo/Soap/index.php?WSDL';
        $this->Con = new nusoap_client($URL); //conexion
        $err       = $this->Con->getError(); //valida
        if ($err)
        {
            $this->Con = FALSE;
        }
    }
    private function Call($Funtion, $Param)
    {
        $this->GetError = TRUE;
        $result         = $this->Con->call($Funtion, $Param);
        if ($this->Con->fault)
        {
            $this->GetError = $result;
        }
        else
        {
            $err = $this->Con->getError();
            if ($err)
            {
                $this->GetError = $err;
            }
            else
            {
                return $result;
            }
        }
        return $this->GetError;
    }

    private function Values($Values)
    {
        $Datos  = array();
        $Values = json_decode($Values);
        foreach ($Values as $value)
        {
            $Temp    = array($value[0], $value[1]);
            $Datos[] = $Temp;
        }
        return $Datos;
    }
    public function Datos($Funcion, $Parametros=array())
    {
        return $this->Call($Funcion, $Parametros);
    }

}
