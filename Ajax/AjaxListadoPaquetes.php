<?php

include_once '../Controller/Servicios.php';
$Paquetes = new Servicios();
$Datos    = $Paquetes->VerPaquetes();
$Res      = array();
for ($i = 0; $i < 3 && isset($Datos[$i]); $i++)
{
    $Res[] = $Datos[$i];
}
foreach ($Res as $Temp)
{
    echo '<div class="col-sm-6 col-md-4">
                            <div class="thumbnail">
                                <div class="caption">
                                    <h2>' . $Temp['Nombre'] . '</h2>
                                </div>
                                <a href="#"><img src="' . $Temp['urlFoto'] . '" alt="..."></a>
                                <div class="caption">
                                    <h4 class="price" align="right">$' . number_format($Temp['Valor'], 0,'.',',') . '</h4>
                                    <p><a href="#" class="ReadMore" role="button">Ver mas</a></p>
                                </div>
                            </div>
                        </div>';
}