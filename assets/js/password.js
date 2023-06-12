var password = false;
var repeatPassword = false;

$(function() {

    $("#password").change(function() {

        let value = $(this).val();

        if (value.length === 0)
            password = false;

        else
            password = true;

        compruebaPasswords();
    })

    $("#repeat-password").change(function() {

        let value = $(this).val();

        if (value.length === 0)
            repeatPassword = false;

        else
            repeatPassword = true;

        compruebaPasswords();
    })

    $("#change-password").click(function() {

        let btn = $(this);

        btn.prepend(spinner);
        btn.attr("disabled", "true");

        let contra = $("#password").val();
        let repeatContra = $("#repeat-password").val();

        $("#alert-password").attr("hidden");

        $.ajax({
            url: "./cambiarPassword", 
            type: "POST", 
            dataType: "json", 
            data: {
                contra: contra, 
                repeatContra: repeatContra
            }, 
            success: function(response) {

                if (response.data === "errorIncorrectData") {
                    $('#alert-password').html("Los datos son incorrectos. Por favor, verifica la información ingresada.");
                    $("#alert-password").removeAttr("hidden");
                    btn.find("spinner-border").remove();
                    btn.removeAttr("disabled");
                }
                    
                else if (response.data === "errorBadUpdate") {
                    $('#alert-password').text("Error al actualizar los datos. Inténtalo nuevamente más tarde.");
                    $("#alert-password"),removeAttr("hidden");
                    btn.find("spinner-border").remove();
                    btn.removeAttr("disabled");
                }
                else
                    window.location.href = "..";
            }
        })
    })
})

function compruebaPasswords()
{
    if (password && repeatPassword)
        $("#change-password").removeAttr("disabled");
    
    else
        $("#change-password").attr("disabled", "true");
}