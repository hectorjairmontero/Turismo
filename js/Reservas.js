function Reservar()
{
    var datos=$('#DatosCliente').serialize();
    $.ajax({
        url:'Ajax/AjaxGuardarReservaClientes.php',
        type:'post',
        data:datos,
        success: function (Resultado) {
            $('#Log').html(Resultado);
        }
    });
}
function CargarLista()
{
    $.ajax({
        type: 'post',
        url: 'Ajax/AjaxVerServiciosReservarProveedor.php',
        data: {
            idPaquetes: $('#idPaquetes').val()
        },
        success: function (Resultado)
        {
            $('#Servicios').html(Resultado);
        }

    });
}
function CargarPaquetes()
{
    $.ajax({
        url: 'Ajax/AjaxVerArmarPaquetes.php',
        success: function (Res)
        {
            Res = JSON.parse(Res);
            $('#Proveedor').html(Res.Paquetes);
        }
    });
}
function inicio()
{
    $('#DatosCliente').submit(false);
    $('#Fecha').datepicker({ dateFormat: 'yy-mm-dd' });
    $('#Nombres').autocomplete({
        source: 'Ajax/AjaxClientesAutocomplete.php',
        search: function (data)
        {
            $('#Tipoid').val('');
            $('#Documento').val('');
            $('#Email').val('');
            $('#Telefono').val('');
        },
        select: function (event, data)
        {
            data = data.item;
            $('#Nombres').val(data.Nombres + ' ' + data.Apellidos);
            $('#Tipoid').val(data.TipoID);
            $('#Documento').val(data.Numero_Id);
            $('#Email').val(data.Email);
            $('#Telefono').val(data.Telefono);
        }
    });
}
$(function ()
{
    inicio();
    CargarPaquetes();
});