<?php
$Menu='<ul class="nav nav-pills">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Proveedores<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="ver_proveedores.html">Ver proveedores</a></li>
                <li><a href="registros.html">Registrar proveedores</a></li>
            </ul>
        </li>
        
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Paquetes<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#">Ver paquetes</a></li>
                <li><a href="NuevoPaquete.html">Registrar paquetes</a></li>
                <li><a href="ver_paquetes.html">Editar paquetes</a></li>
            </ul>
        </li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Servicios<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#">Ver servicios</a></li>
                <li><a href="#">Editar servicios</a></li>
                <li><a href="#">Ver estados</a></li>
                <li><a href="#">Editar estados</a></li>
            </ul>
        </li>
        
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Cliente<b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li><a href="#">Autorizar cotizacion</a></li>
                <li><a href="#">Verificar pagos</a></li>
            </ul>
        </li>
        
       </ul>';
echo $Menu;