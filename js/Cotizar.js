var CodUsuario;
function buscarservicios()
{
    var datos = $('#id_proveedores').val();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxCargarServiciosProveedor.php",
        data: {proveedor: datos},
        success: function (res)
        {
            $('#servicios').html(res);
        }
    });
}
function registrarse()
{

    var datos = $('#RegistroUsuario').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxRegistrarseCliente.php",
        data: datos,
        success: function (cod)
        {

            cod = JSON.parse(cod);
            var id=JSON.parse(cod.id);
            usuariovalido(id.id_cliente);
        }
    });
}

function GuardarDetalleCotizacion()
{

}
function GuardarDetalleCotizacion()
{
    var data = $('#ArmarCotizaciones').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxGuadarDetalleCotizacion.php",
        data: data,
        success: function (Res)
        {
            $('#Listad').html(Res);
        }
    });
}
function GuardarCotizacion()
{
    var datos = $('#FormDescripcionCotizacion').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxRegistrarseCotizacion.php",
        data: datos,
        success: function (cod)
        {

            $('#CodCabCotizacion').val(cod);
            $('#ArmarCotizacion').show();
            $('#DescripcionCotizacion').hide();
        }
    });

}
function usuariovalido(cod)
{
    $('#codusuario').val(cod);
    var datos = JSON.parse(cod);
    $('#proveedor').load('Ajax/AjaxVerServiciosProveedor.php');
    $('#DescripcionCotizacion').show();
    $('#LogUsuario').hide();
    $('#RegistroUsuario').hide();
}
function validarusuario()
{
    var datos = $('#LogUsuario').serialize();
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxLogUsuario.php",
        data: datos,
        success: function (Resultado)
        {
            Resultado = JSON.parse(Resultado);
            if (Resultado.sivalido)
            {
                var datos = JSON.parse(Resultado.id);
                usuariovalido(datos.id_cliente);
            }
            else
            {
                alert('No se encontro usuario');
            }
        }
    });
}
$(function ()
{
    $('#LogUsuario').submit(false);
    $('#RegistroUsuario').submit(false);
    $('#ArmarCotizacion').submit(false);
    $('#DescripcionCotizacion').submit(false);

    $('#ArmarCotizacion').hide();
    $('#DescripcionCotizacion').hide();

});