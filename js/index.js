function VerPaquetes()
{
    $.ajax({
        type: 'POST',
        url: "Ajax/AjaxListadoPaquetes.php",
        success: function (Resultado)
        {
            $('#ListaPaquetes').html(Resultado);
        }
    });
}
$(function(){
    VerPaquetes();
});