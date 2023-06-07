/**
 * Al pulsar el botón de confirmar reserva, se abrirá un modal con todas las mesas disponibles
 * para asignar mesa y confimar la reserva
 */

$(".b-confirmar-reserva").click(function() {

    let nComensales = $(this).closest('.reserva-contenedor').find('.reserva-ncomensales span').text();
    let fecha = $(this).closest('.reserva-contenedor').find('.reserva-fecha span').text();
    let idReserva = $(this).closest(".reserva").data("index");

    let email = $(this).closest(".reserva").attr("data-email");
    let fullName = $(this).closest(".reserva-contenedor").find(".reserva-nombre span").text();

    let divReserva = $(this).closest(".reserva");

    $(".modal-body").empty();

    let loading = '<div class="loading">' + 
            '<div class="spinner"></div>' + 
            '<span class="cargando">Cargando mesas disponibles...</span>' + 
            '</div>';

    $(".modal-body").html(loading);

    $(".modal .modal-title").text("Confirmar Reserva de Mesa");
    abrirModal();

    $.ajax({
        url: "./mostrarMesas", 
        type: "POST", 
        dataType: "json", 
        data: {
            n_comensales: nComensales, 
            fecha: fecha, 
            email: email, 
            full_name: fullName 
        },
        success: function(response) {

            $(".modal-body").empty();

            if (response.length !== 0) {

                let mesas = '<label for="mesasDisponibles">Elija una mesa de las disponibles:</label>' +
                        '<div class="mesasDisponibles">';

                for (let mesa of response)
                    mesas += '<button class="bMesa">' + mesa.id_mesa + '</button>';

                mesas += '</div>' +
                        '<div class="btn-modal text-center">' +
                        "<button disabled type='button' class='btn btn-success confirmar'>\nConfirmar\n</button>" +
                        '</div>';

                $(".modal-body").html(mesas);
            }
            else {

                $(".modal-body").html('<div class="text-center"><b style="color: red;"><i>¡No existen mesas para esta fecha con estos comensales!</i></b></div>')
            }

            /**
             * Al pulsar el botón de confirmar, se informará al recepcionista del envío del email
             * al cliente con la confirmación de reserva con la mesa elegida.
             */

            
            $(".confirmar").click(function() {

                let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
                $(this).prepend(spinner);
                $(this).attr("disabled", "true");

                $.ajax({
                    url: "./confirmarReservaMesa", 
                    type: "POST", 
                    dataType: "json", 
                    data: {
                        id_reserva_mesa: idReserva, 
                        id_mesa: $(".bMesa-active").text()
                    },
                    success: function(response) {

                        $(".modal-body").empty();
                        $(".modal-body").html("<p>" + response.data + "</p>");

                        divReserva.remove();
                    }
                })
            })
            

            $(".bMesa").on("click", function() {

                $(".bMesa-active").removeClass("bMesa-active");
                $(this).addClass("bMesa-active");

                $(".confirmar").removeAttr("disabled");
            })
        }
    })
})

/**
 * Al pulsar el botón de confirmar reserva, se abrirá un modal con todas las mesas disponibles
 * para asignar mesa y confimar la reserva
 */

$(".b-rechazar-reserva").click(function() {

    $(".modal-body").empty();

    $(".modal .modal-title").text("Rechazar Reserva de Mesa");
    abrirModal();
})