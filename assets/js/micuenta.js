var telefonoOk = true;
var emailOk = true;

$(function() {

    $(".inp-cuenta").change(function() {

        $("#modifica").removeAttr("disabled");
    })

    $("#telefono").change(function() {

        let numero = $(this).val();
        if (numero.length !== 9) {
            $("#telefono-text").text("El nº de teléfono debe tener más de 9 caractéres");
            telefonoOk = false;
        }
        else if (/\D/.test(numero)) {
            $("#telefono-text").text("El nº de teléfono no debe contener ninguna letra");
            telefonoOk = false;
        }
        else {
            $("#telefono-text").text("");
            telefonoOk = true;
        }

        compruebaCampos();
    })

    $("#email").change(function() {

        let email = $(this).val();
        if (email.indexOf('@') !== -1) {
            $("#email-text").text("El email debe tener un @");
            emailOk = false;
        }
        else {
            $("#email-text").text("");
            emailOk = true;
        }

        compruebaCampos();
    })

    $("#modifica").click(function() {

        let btn = $(this);
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        btn.prepend(spinner);
        btn.attr("disabled", "true");

        let email = $("#email").val();
        let nombre = $("#nombre").val();
        let apellido = $("#apellido").val();
        let telefono = $("#telefono").val();

        $("#alert-cuenta").attr("hidden");

        $.ajax({
            url: "./cambiaDatosCuenta", 
            type: "POST", 
            dataType: "json", 
            data: {
                email: email, 
                nombre: nombre, 
                apellido: apellido, 
                telefono: telefono
            }, 
            success: function(response) {

                if (response.data === "errorIncorrectData") {
                    $('#alert-cuenta').html("Los datos son incorrectos. Por favor, verifica la información ingresada.");
                    $("#alert-cuenta").removeAttr("hidden");
                    btn.find("spinner-border").remove();
                    btn.removeAttr("disabled");
                }
                    
                else if (response.data === "errorBadUpdate") {
                    $('#alert-cuenta').text("Error al actualizar los datos. Inténtalo nuevamente más tarde.");
                    $("#alert-cuenta"),removeAttr("hidden");
                    btn.find("spinner-border").remove();
                    btn.removeAttr("disabled");
                }
                else
                    window.location.href = "..";
            }
        })
    })
})

function compruebaCampos() {

    if (telefonoOk && emailOk)
        $("#modifica").removeAttr("disabled");
    else
        $("#modifica").attr("disabled", "true");
}