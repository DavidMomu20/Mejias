/**
 * Al pulsar el botón de confirmar reserva, se abrirá un modal con todas las mesas disponibles
 * para asignar mesa y confimar la reserva
 */

$(".b-confirmar-reserva").click(function() {

    let idReserva = $(this).closest('.reserva').data('index');

    $(".modal-body").empty();

    let loading = '<div class="loading">' + 
            '<div class="spinner"></div>' + 
            '<span class="cargando">Cargando mesas disponibles...</span>' + 
            '</div>';

    $(".modal-body").html(loading);

    $(".modal").addClass("fade");
        setTimeout(function() {
            $(".modal").addClass("show");
        }, 25);

    $(".modal .modal-title").text("Confirmar Reserva de Mesa");
    $(".modal").show();

    console.log($(this).closest('.reserva-contenedor').find('.reserva-fecha span').text());

    $.ajax({
        url: "./mostrarMesas",
        type: "POST", 
        dataType: "json",
        data: {
            n_comensales: $(this).closest('.reserva-contenedor').find('.reserva-ncomensales span').text(), 
            fecha: $(this).closest('.reserva-contenedor').find('.reserva-fecha span').text()
        },
        success: function(response) {

            $(".modal-body").empty();

            let mesas = '<label for="mesasDisponibles">Elija una mesa de las disponibles:</label>' +
                        '<div class="mesasDisponibles">';

            let botonesMesa = "";
            for (let mesa of response)
                botonesMesa += '<button class="bMesa" data-value="' + mesa.id_mesa + '">' + mesa.id_mesa + '</button>';

            mesas += botonesMesa;

            mesas += '</div>' +
                    '<div class="btn-modal text-center">' +
                    '<button type="button" class="btn btn-success confirmar">Confirmar</button>' +
                    '</div>';

            $(".modal-body").html(mesas);

            /**
             * Al pulsar el botón de confirmar, se informará al recepcionista del envío del email
             * al cliente con la confirmación de reserva con la mesa elegida.
             */

            /*
            $(".confirmar").click(function() {
                
                $.ajax({
                    url: "../confirmarReservaMesa/" + idReserva, 
                    type: "POST", 
                    dataType: "json", 
                    data: {
                        id_mesa: $(".bMesa-active").data("value"),
                    }, 
                    success: function(response) {
                        console.log(response.data);
                    }
                })

            })
            */

            $(".bMesa").on("click", function() {

                $(".bMesa-active").removeClass("bMesa-active");
                $(this).addClass("bMesa-active");
            })
        }
    })

    $(".modal [aria-label=Close]").on("click", function() {

        $(".modal").removeClass("fade");
        $(".modal").removeClass("show");
      
        $(".modal").hide();
    })
})

/**
 * Al pulsar el botón de confirmar reserva, se abrirá un modal con todas las mesas disponibles
 * para asignar mesa y confimar la reserva
 */

$(".b-rechazar-reserva").click(function() {

    $(".modal").addClass("fade");
    setTimeout(function() {
        $(".modal").addClass("show");
    }, 25);

    $(".modal .modal-title").text("Rechazar Reserva de Mesa");
    $(".modal").show();

    $(".modal [aria-label=Close]").on("click", function() {
    
        $(".modal").removeClass("fade");
        $(".modal").removeClass("show");
      
        $(".modal").hide();
      })
})