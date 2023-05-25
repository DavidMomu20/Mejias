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
})