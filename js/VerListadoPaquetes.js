function Lista()
{
    $.ajax({
        url: "Ajax/AjaxVerPaquetes.php",
        success: function (Resultado)
        {
            $('#contenido').html(Resultado);
        }
    });
}
$(function ()
{
    Lista();
});