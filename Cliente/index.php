<html>
    <head>
        <meta charset="utf-8">
        <title>prueba de webservices</title>
    </head>
    <body>

        <?php
        include_once '../Codigo/ClassVisual.php';
        include_once './Class/WebService.php';
        $Visual      = new Visual();
        $Ver         = new WebService();
        $Municipios  = ($Ver->VerMunicipios());
        $Indicadores = ($Ver->VerIndicadores());
        $ValueM      = '';
        $ValueI      = '';
        if ($_GET)
        {
            $ValueI = $_GET['indicador'];
            $ValueM = $_GET['Municipio'];
        }
        $Municipio = $Visual->Select($Municipios, 'Municipio', $ValueM);
        $Indicador = $Visual->Select($Indicadores, 'indicador', $ValueI);
        ?>

        <form action="index.php" method="get">

            indicador<?php echo $Indicador; ?><br/>
            Municipio<?php echo $Municipio; ?><br/>
            Formato<select name="Formato">
                <option value="DatosTangaraHTML">Formato HTML</option>
                <option value="DatosTangara">Formato JSON</option>
            </select><br/>
            <input type="submit" value="Buscar">
        </form>
        <hr>
        <?php
        if ($_GET)
        {
            switch ($_GET['Formato'])
            {
                case 'DatosTangaraHTML':
                    $Res = ($Ver->DatosHtml($_GET['indicador'], $_GET['Municipio']));
                    $Imp= '<h1>Dimensión: '.$Res->Dimension.'</h1>';
                    $Imp.= '<h1>Temática: '.$Res->Tematica.'</h1>';
                    $Imp.= '<h1>Indicador: '.$Res->Indicador.'</h1>';
                    $Imp.= '<h1>Municipio: '.$Res->Municipio.'</h1>';
                    $Imp.= $Res->Tabla;
                    $Imp.= $Res->Fuente;
                    echo $Imp;
                    break;
                case 'DatosTangara':
                    $Res = ($Ver->DatosTangara($_GET['indicador'], $_GET['Municipio']));
                    print_r(($Res));
                    break;
            }
        }
        ?>
    </body>
</html>