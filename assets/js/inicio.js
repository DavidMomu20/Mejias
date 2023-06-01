$(function() {

    let haySesion = (($(".div-opReservas").data("haysesion") == 1) ? true : false);
        
    if (haySesion) {

        $("#reservarMesa").click(function() { window.location.href = "./reservar/mesa"; })
        $("#reservarHabitacion").click(function() { window.location.href = "./habitaciones"; })
    }

    $("#b-verCarta").click(function() {
        window.location.href = "./assets/files/CARTA-MEJIAS.pdf";
        document.title = "Carta - Hostal Restaurante Mejías";
    })

    // ========================================

    $("button.login").on("click", function(e) {

        e.preventDefault();

        let btn = $(this);
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $(".card-body").find(".alert-danger").remove();
        
        $(this).prepend(spinner);
        $(this).attr("disabled", "true");
        $(this).text("Enviando...");

        $.ajax({
            url: "./doLogin", 
            type: "POST", 
            dataType: "json", 
            data: {
                email_login: $("#email-login").val(), 
                password_login: $("#password-login").val()
            }, 
            success: function(response) {

                $(this).text("Redirigiendo...");

                if (response.data === "error") {
                    btn.find(".spinner-border").remove();
                    btn.removeAttr("disabled");

                    let alertDanger = '<div class="alert alert-danger" role="alert">El correo y la contraseña introducidos no existen en la base de datos.</div>';
                    $(".card-body").prepend(alertDanger);
                }
                else
                    window.location.href = response.data
            }
        })
    })

    // ========================================

    $("button.register").on("click", function(e) {

        e.preventDefault();

        let btn = $(this);
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

        $(".card-body").find(".alert-danger").remove();
        
        $(this).prepend(spinner);
        $(this).attr("disabled", "true");

        $.ajax({
            url: "./doRegister", 
            type: "POST", 
            dataType: "json", 
            data: {
                email_register: $("#email-register").val(), 
                password_register: $("#password-register").val(), 
                nombre: $("#nombre").val(), 
                apellido: $("#apellido").val(), 
                phone: $("#phone").val()
            }, 
            success: function(response) {

                if (response.data === "errorNotUserFound") {

                    btn.find(".spinner-border").remove();
                    btn.removeAttr("disabled");

                    let alertDanger = '<div class="alert alert-danger" role="alert">El correo y la contraseña introducidos YA existen en la base de datos.</div>';
                    $(".card-body").prepend(alertDanger);
                }
                else if (response.data === "errorBadInsert") {

                    btn.find(".spinner-border").remove();
                    btn.removeAttr("disabled");

                    let alertDanger = '<div class="alert alert-danger" role="alert">No se ha introducido el usuario correctamente.</div>';
                    $(".card-body").prepend(alertDanger);
                }
                else
                    window.location.href = response.data
            }
        });
    })
})