function VerListado(Pagina)
{
    var municipio = $('#id_municipios').val();
    var FechaInicion = $('#FechaIncio').val();
    var FechaFin = $('#FechaFin').val();
    var n_pagina = Pagina;
    var cantidad_registros_pagina = 5;
    $.ajax({
        type: "POST",
        url: "./Ajax/AjaxVerListadoPaquetes.php",
        data: {
            municipio: municipio,
            FechaInicion: FechaInicion,
            FechaFin: FechaFin,
            n_pagina: n_pagina,
            cantidad_registros_pagina: cantidad_registros_pagina
        },
        success: function (Res)
        {
            $('#listado').html(Res);
        }
    });
}
function Buscar()
{

    VerListado(1);
}
function Iniciar()
{
    $('#FechaIncio').datepicker();
    $('#FechaFin').datepicker();
    $('#selectMunicipios').load('Ajax/AjaxSelectMunicipios.php');
}
$(function ()
{
    Iniciar();
    VerListado(1);
});