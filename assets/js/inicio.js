var restauranteLatitud = 37.13323221549376;
var restauranteLongitud = -4.296913824354528;

$(function() {

    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            let miLatitud = position.coords.latitude;
            let miLongitud = position.coords.longitude;
            
            let distancia = calcularDistancia(miLatitud, miLongitud, restauranteLatitud, restauranteLongitud);
            
            $(".div-distancia span").text(distancia.toFixed(2) + " km");
        });
    } 
    else
        $(".div-distancia").remove();

    let haySesion = (($(".div-opReservas").data("haysesion") == 1) ? true : false);
        
    if (haySesion) {

        $("#reservarMesa").click(function() { window.location.href = "./reservar/mesa"; })
        $("#reservarHabitacion").click(function() { window.location.href = "./habitaciones"; })
        $("#ver-habitaciones").click(function() { window.location.href = "./habitaciones"; })
    }
    else {

        $("#ver-habitaciones").attr("data-bs-toggle", "modal");
        $("#ver-habitaciones").attr("data-bs-target", "#modalLogin");
    }
    
    // ========================================

    $("button.login").on("click", function(e) {

        e.preventDefault();

        let btn = $(this);

        $(".card-body").find(".alert-danger").remove();
        
        $(this).html(spinner + "\nEnviando...");
        $(this).attr("disabled", "true");

        $.ajax({
            url: "./doLogin", 
            type: "POST", 
            dataType: "json", 
            data: {
                email_login: $("#email-login").val(), 
                password_login: $("#password-login").val()
            }, 
            success: function(response) {

                if (response.data === "error") {
                    btn.find(".spinner-border").remove();
                    btn.removeAttr("disabled");
                    btn.html("Enviar");

                    let alertDanger = '<div class="alert alert-danger" role="alert">El correo y la contraseña introducidos no existen en la base de datos.</div>';
                    $(".card-body").prepend(alertDanger);
                }
                else {
                    btn.html(spinner + "\nRedirigiendo...");
                    window.location.href = response.data;
                }
            }
        })
    })

    // ========================================

    $("button.register").on("click", function(e) {

        e.preventDefault();

        let btn = $(this);

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

function calcularDistancia(lat1, lon1, lat2, lon2) {

    let radioTierra = 6371; // Radio de la Tierra en kilómetros

    let dLat = toRad(lat2 - lat1);
    let dLon = toRad(lon2 - lon1);

    let a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    let c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    let distancia = radioTierra * c;
    return distancia;
}
  
function toRad(grados) {
    return grados * Math.PI / 180;
}