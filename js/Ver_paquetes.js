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
function CargarDatosid(id)
{
    $.ajax({
        url: "Ajax/AjaxVerArmarPaquetes.php",
        type:'POST',
        data:{id:id},
        success: function (Resultado)
        {
            Resultado = JSON.parse(Resultado);
            $('#Paquetes').html(Resultado.Paquetes);
            CargarLista();
        }
    });
}
function CargarLista()
{
    var Paquetes = $('#idPaquetes').val();
    $('#paquetehiden').val(Paquetes);
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
function GuardarPaquetes()
{
    var data = $('#id_paqueteform').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxEditarInfoPaquete.php",
        data: data,
        success: function (Resultado)
        {
            $('#cont_delete').html(Resultado);
            $('#myModal').modal('show');
        }
    });
}
function Eliminar(cod)
{
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxEliminarServicioPaquete.php",
        data: {
            id: cod,
            Paquetes: $('#idPaquetes').val()
        },
        success: function (Resultado)
        {
            $('#cont_delete').html(Resultado);
            $('#myModal').modal('show');
            CargarLista();
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
            $('#ServiciosProveedor').html('<div class="col-lg-2"><label>Servicios</div></label><div class="col-lg-10">' + Resultado + '</div>');
        }
    });
}

function VerProveedores()
{
    $('#Listaproveedor').load('Ajax/AjaxVerServiciosProveedor.php');
}
$(function ()
{
    if (typeof (getUrlVars()['id']) != "undefined")
    {
        CargarDatosid(getUrlVars()['id']);
    }
    else
    {
        CargarDatos();
    }
    CargarLista();
    VerProveedores();
    $('#id_paqueteform').submit(false);
});