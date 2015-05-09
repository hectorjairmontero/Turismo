function Pagar(cod)
{
    $.ajax({
        url: 'Ajax/AjaxPagarCliente.php',
        type: 'post',
        data: {id: cod},
        success: function (data)
        {
            $('#Reservas').html(data);
            Cargar();
        }
    });
}
function editar(cod)
{
    $.ajax({
        url: 'Ajax/AjaxVerServiciosReservaCliente.php',
        type: 'post',
        data: {id: cod},
        success: function (data)
        {
            $('#Reservas').html(data);
        }
    });
}
function Cargar()
{
    $('#Reservas').load('Ajax/AjaxVerReservasClientes.php');
}
$(function ()
{
    Cargar();
});