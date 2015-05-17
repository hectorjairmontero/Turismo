function Detalle(cod)
{
    $.ajax({
        url: 'Ajax/AjaxDetallePagosProveedores.php',
        type: 'post',
        data: {id: cod},
        success: function (Resultados)
        {
            $('#Resultados').html(Resultados);
        }
    });
}
function Buscar()
{
    var data = $('#Fechas').serialize();
    $.ajax({
        url: 'Ajax/AjaxBuscarPagosProveedores.php',
        type: 'post',
        data: data,
        success: function (Resultados)
        {
            $('#Resultados').html(Resultados);
        }
    });
}
$(function ()
{
    $('#Fechas').submit(false);
    $('#FechaInicio').datepicker({dateFormat: 'yy-mm-dd'});
    $('#FechaFin').datepicker({dateFormat: 'yy-mm-dd'});
});