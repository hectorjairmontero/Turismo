$("Formulario").submit(function (event) {

    return false;
});

function Guardar()
{
    var datos = $('#Formulario').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxGuardarPaquete.php",
        data: datos,
        success: function (Resultado)
        {
             CargarPaquetes();
        }
    });
}
function CargarPaquetes()
{
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxVerPaquetes.php",
        success: function (Resultado)
        {
            $('#ListadoPaquetes').html(Resultado);
        }
    });
}
function formatearfechas()
{
    $('#FechaIncio').datepicker({dateFormat: 'yy-mm-dd'});
    $('#FechaFin').datepicker({dateFormat: 'yy-mm-dd'});
}
function CargarMunicipios()
{
    $('#Municipios').load('Ajax/AjaxSelectMunicipios.php');
}
$(function ()
{
    formatearfechas();
    CargarPaquetes();
    CargarMunicipios();
    $("#Formulario").submit(function ()
    {
        return false;
    });
});