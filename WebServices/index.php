<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once 'Class/WebService.php';
        $Con = new WebService();
        echo '<pre>';
        $Res=$Con->Datos('CuentasProveedorTotal',array('Cod_proveedor'=>'PSIIT0001','FechaIncial'=>'2001-01-01','FechaFinal'=>'2090-01-01'));
        $Values=  json_decode($Res);
        echo '<h1>Paquete: $'.($Values[0]->paquete).'</h1>';
        echo '<h1>Servicio: $'.($Values[0]->servicio).'</h1>';
        echo '<h1>ganancia: $'.($Values[0]->ganancia).'</h1>';
        echo '<h1>Valor unitario: $'.($Values[0]->valor_unitario_servicio).'</h1>';
        echo '<h1>Valor: $'.($Values[0]->valor_neto).'</h1>';
        echo '<h1>Cantidad: $'.($Values[0]->cantidad_servicios).'</h1>';
        echo '<h1>Admin : %'.($Values[0]->porcentaje_admin).'</h1>';
        echo '<h1>Comision admin: $'.($Values[0]->porcentaje_admin*$Values[0]->valor_unitario_servicio)/100;
        ?>
    </body>
</html>
