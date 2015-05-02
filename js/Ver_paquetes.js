function Guardar()
{
    var paquete = $('#idPaquetes').val();
    var Servicio = $('#idServicios').val();
    var Cantidad = $('#cantidad').val();
    var Precio = $('#Precio').val();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxCrearPaquete.php",
        data: {
            paquete: paquete,
            Servicio: Servicio,
            Cantidad: Cantidad,
            Precio: Precio
        },
        success: function (Resultado)
        {
            alert(Resultado);
            CargarLista();
        }
    });
}
function CargarDescripcion(Paquetes)
{
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxDescripcionPaquete.php",
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
        url: "Ajax/AjaxVerArmarPaquetes.php",
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
        url: "Ajax/AjaxCargarListadoPaquetes.php",
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
function buscarservicios()
{
    var proveedor = $('#id_proveedores').val();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxCargarServiciosProveedor.php",
        data: {
            proveedor: proveedor
        },
        success: function (Resultado)
        {
            $('#ServiciosProveedor').html('<div class="col-lg-1"><label>Servicios</div></label><div class="col-lg-11">' + Resultado + '</div>');
        }
    });
}
function VerProveedores()
{
    $('#Listaproveedor').load('Ajax/AjaxVerServiciosProveedor.php');
}
$(function ()
{
    CargarDatos();
    CargarLista();
    VerProveedores();
});