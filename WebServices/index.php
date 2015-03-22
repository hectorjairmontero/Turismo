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
        $Res=$Con->Datos('VerPaquetesServicios');
        $Values=  json_decode($Res);
        print_r($Values->Servicios);
        echo '</pre>';
        ?>
    </body>
</html>
