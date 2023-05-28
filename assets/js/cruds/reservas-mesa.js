$(function() {

    $("#tabla-reservas-mesa tbody tr").on("click", function() {

        $(".modal .modal-title").text("Datos Reserva Mesa");
        abrirModal();
    })
})