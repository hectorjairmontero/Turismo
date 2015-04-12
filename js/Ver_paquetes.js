function CargarDescripcion(Paquetes)
{
    $.ajax({
        type: 'POST',
        url: "../Ajax/AjaxDescripcionPaquete.php",
        data: {
            Paquetes: Paquetes
        },
        success: function (Resultado)
        {
            $('#Panel').html(Resultado);
        }
    });
}
function CargarDatos()
{
    $.ajax({
        url: "../Ajax/AjaxVerArmarPaquetes.php",
        success: function (Resultado)
        {
            Resultado = JSON.parse(Resultado);
            $('#Paquetes').html(Resultado.Paquetes);
        }
    });
}
function CargarLista()
{
    var Paquetes = $('#idPaquetes').val();
    var NombrePaquete = $('#idPaquetes:selected').text();
    $.ajax({
        type: 'POST',
        url: "../Ajax/AjaxCargarListaPaquetes.php",
        data: {
            Paquetes: Paquetes
        },
        success: function (Resultado)
        {
            $('#Lista').html(Resultado);
            $('#Texto_lista').html('Servicios del paquete ' + NombrePaquete);
            CargarDescripcion(Paquetes);
        }
    });
}
$(function ()
{

    CargarDatos();
    CargarLista();
});