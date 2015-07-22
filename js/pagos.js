function imprimir(asd)
{
    window.print();
}
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
function buscarservicios()
{
    Buscar();
}
function selectProveedor()
{
    $.ajax({
        url: 'Ajax/AjaxVerServiciosProveedor.php',
        success: function (Resultados)
        {
            $('#selectProveedor').html(Resultados);
        }
    });
}
$(function ()
{
    selectProveedor();
    $('#Fechas').submit(false);
    $('#FechaInicio').datepicker({dateFormat: 'yy-mm-dd'});
    $('#FechaFin').datepicker({dateFormat: 'yy-mm-dd'});
});