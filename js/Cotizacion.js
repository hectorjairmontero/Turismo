function GuardarCambios()
{
    var data = $('#Actualizando').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxGuardarCambiosCotizacion.php",
        data: data,
        success: function (res)
        {
            $('#Contenido').html(res);
            $('#myModal').modal('show');
        }
    });
}
function VerDetalle(cab)
{
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxVerCotizacionesClientes.php",
        data: {id: cab},
        success: function (res)
        {
            res = JSON.parse(res);
            $('#Contenido').html(res.Datos);
            $('#Title').html('<h4 class="modal-title" id="myModalLabel">' + res.Total + '</h4>');
            $('#myModal').modal('show');
        }
    });
}
$(function ()
{
    $('#cotizaciones').load('Ajax/AjaxVerCotizaciones.php');
    $('#Actualizando').submit(false);
});