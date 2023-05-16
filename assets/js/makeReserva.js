$("button").click(function(e) {

    e.preventDefault();
})

$(".horas button").click(function() {

    // Buscar si hay algún boton con la clase "horaa-activo"
    let horaActiva = $(".hora-activa");

    // Si se encuentra, eliminar la clase
    if (horaActiva.length > 0) {
        horaActiva.removeClass("hora-activa");
    }

    $(this).addClass("hora-activa");
})

$("#bReservarMesa").click(function() {

    let errores = [];

    // Comprobar si se ha elegido un dia
    let fecha = $(".date-reserva").data("value");
    if (fecha === "")
        errores.push("No se ha elegido una fecha");

    // Comprobar si se ha elegido una hora
    let hora = $(".hora-activa").text();
    if (hora === "")
        errores.push("No se ha elegido una hora");

    let nComensales = $("#n_comensales").val();

    if (errores.length == 0) {

        $("#bReservarMesa").css({"display": "none"});
        $(".loading").css({"display": "inline-block"});

        $.ajax({
            url: "./reservarMesa", 
            type: "POST",
            dataType: "json", 
            data: {
                fecha: fecha, 
                hora: hora, 
                n_comensales: nComensales
            }, 
            success: function(response) {
                
                $(".loading").css({"display": "none"});
                $("#bReservarMesa").css({"display": "inline-block"});

                $(".toast-header strong").text("Reserva de mesa realizada con éxito");
                $(".toast-body").text("Se le enviará un correo con la reserva confirmada o rechazada. Si lo desea, puede realizar otra reserva.");

                $("#liveToast").toast('show');
            }
        })
    }

})