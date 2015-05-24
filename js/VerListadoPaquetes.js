function Bloquear(id)
{
    $.ajax({
        url: "Ajax/AjaxBloquearPaquetes.php",
        type:'POST',
        data:{id:id},
        success: function()
        {
            Lista();
        }
    });
}
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