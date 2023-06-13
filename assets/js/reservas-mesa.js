var loading = $('<div>').addClass('loading')
    .append($('<div>').addClass('spinner'))
    .append($('<span>').addClass('cargando').text('Cargando mesas disponibles...'));

var razones = $('<div>').addClass('cont-razones text-center')
.append(
    $('<label>').addClass('form-label').attr('for', 'razones').text('¿A qué se debe el rechazo de esta reserva?:'),
    $('<select>').addClass('form-control mt-3').attr('name', 'razones').attr('id', 'razones')
        .append(
            $('<option>').attr('value', 'sin-mesas').prop('selected', true).text('No existen mesas disponibles'),
            $('<option>').attr('value', 'mal-comportamiento').text('Comportamiento negativo previo'),
            $('<option>').attr('value', 'otro').text('Otro...')
        ),
    $('<div>').addClass('otra-razon-div mt-3 d-none')
        .append(
            $('<label>').addClass('form-label').attr('for', 'otra-razon').text('Detalle el problema, por favor:'),
            $('<textarea>').addClass('form-control').attr('name', 'otra-razon').attr('id', 'otra-razon').attr('cols', '5').attr('rows', '10').css('resize', 'none')
        ), 
    $('<div>').addClass('d-flex justify-content-center mt-3').append(
        $('<button>').attr('id', 'b-enviar-rechazo').addClass('btn btn-danger').text("\nEnviar")
    )
);

var razon = "";

/**
 * Al pulsar el botón de confirmar reserva, se abrirá un modal con todas las mesas disponibles
 * para asignar mesa y confimar la reserva
 */

$(".b-confirmar-reserva").click(function() {

    let nComensales = $(this).closest('.reserva-contenedor').find('.reserva-ncomensales span').text();
    let fecha = $(this).closest('.reserva-contenedor').find('.reserva-fecha span').text();
    let idReserva = $(this).closest(".reserva").data("index");

    let divReserva = $(this).closest(".reserva");

    $(".modal-body").empty();

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

                let email = $(this).closest(".reserva").attr("data-email");
                let fullName = $(this).closest(".reserva-contenedor").find(".reserva-nombre span").text();

                $(this).prepend(spinner);
                $(this).attr("disabled", "true");

                $.ajax({
                    url: "./confirmarReservaMesa", 
                    type: "POST", 
                    dataType: "json", 
                    data: {
                        id_reserva_mesa: idReserva, 
                        id_mesa: $(".bMesa-active").text(),
                        email: email, 
                        full_name: fullName 
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

    let idReserva = $(this).closest(".reserva").data("index");
    let email = $(this).closest(".reserva").attr("data-email");
    let fullName = $(this).closest(".reserva-contenedor").find(".reserva-nombre span").text();

    $(".modal .modal-title").text("Rechazar Reserva de Mesa");
    $(".modal-body").html(razones);
    abrirModal();

    $("#razones").change(function() {

        ($(this).val() == "otro")
        ? $(".otra-razon-div").removeClass("d-none")
        : $(".otra-razon-div").addClass("d-none")
    })

    $("#b-enviar-rechazo").click(function() {

        $(this).prepend(spinner);
        $(this).attr("disabled", "true");

        switch($("#razones").val()) {
            case "sin-mesas": 
                razon = "El rechazo de esta reserva se debe a que no hay mesas disponibles en este momento. Lamentamos las molestias y te invitamos a intentarlo nuevamente más tarde.";
                break;
            case "mal-comportamiento":
                razon = "El rechazo de esta reserva se debe a comportamientos negativos previos por parte del cliente. Nos tomamos muy en serio la tranquilidad y comodidad de todos nuestros clientes y, por tanto, hemos decidido no aceptar esta reserva.";
                break;
            default:
                razon = $("#otra-razon").val();
                break;
        }        

        $.ajax({
            url: "./rechazarReservaMesa", 
            type: "POST", 
            dataType: "json", 
            data: {
                id_reserva_mesa: idReserva,
                razon: razon, 
                email: email, 
                full_name: fullName
            }, 
            success: function(response) {

                $(".modal-body").empty();
                $(".modal-body").html("<p>" + response.data + "</p>");

                divReserva.remove();
            }
        })
    })
})