function CargarPaquetes()
{
        $.ajax({
        type: 'POST',
        url: "../Ajax/AjaxVerPaquetes.php",
        success: function (Resultado)
        {
            $('#ListadoPaquetes').html(Resultado);
        }
    });
}
$(function()
{
    CargarPaquetes();
});