var formHabHTML = '<form class="container mb-4">' +
'    <div class="row">' +
'        <div class="col-xl-6">' +
'            <div class="date-reserva">' +
'                Elija los días pulsando en este calendario:' +
'            </div>' +
'            <div class="calendar">' +
'                <div class="calendar-header">' +
'                    <span class="prev-month">&#8249;</span>' +
'                    <span class="current-month-year"></span>' +
'                    <span class="next-month">&#8250;</span>' +
'                </div>' +
'                <div class="calendar-weekdays">' +
'                    <span>Dom</span>' +
'                    <span>Lun</span>' +
'                    <span>Mar</span>' +
'                    <span>Mie</span>' +
'                    <span>Jue</span>' +
'                    <span>Vie</span>' +
'                    <span>Sab</span>' +
'                </div>' +
'                <div class="calendar-days">' +
'                </div>' +
'            </div>' +
'        </div>' +
'        <div class="col-xl-6 d-flex flex-column justify-content-center row-gap-3">' +
'            <div class="row">' +
'                <label for="fecha-inicio-input">Fecha de inicio:</label>' +
'                <input id="fecha-inicio-input" class="form-control" type="text" readonly>' +
'            </div>' +
'            <div class="row mt-2">' +
'                <label for="fecha-fin-input">Fecha de fin:</label>' +
'                <input class="form-control" id="fecha-fin-input" type="text" readonly>' +
'            </div>' +
'            <div class="row mt-3">' +
'                <div class="my-cont-reserva container d-flex flex-column justify-content-center gap-2 p-3">' +
'                    <label for="n_huespedes" class="my-label text-center">¿Cuántas personas sois?</label>' +
'                    <div class="d-flex justify-content-center gap-2">' +
'                        <button type="button" class="bCount bMenos">-</button>' +
'                        <input class="my-input-number" type="number" name="n_huespedes" id="n_huespedes" value="1" min="1" max="10">' +
'                        <button type="button" class="bCount bMas">+</button>' +
'                    </div>' +
'                </div>' +
'            </div>' +
'            <div class="row mt-3">' +
'                <div class="my-cont-reserva container d-flex flex-column justify-content-center gap-2 p-3">' +
'                    <label for="puntos" class="my-label text-center">¿Deseas usar puntos?</label>' +
'                    <div class="d-flex justify-content-center gap-2">' +
'                        <button type="button" class="bCount bMenos">-</button>' +
'                        <input class="my-input-number" type="number" name="puntos" id="puntos" value="0" min="0" max="' + puntos + '">' +
'                        <button type="button" class="bCount bMas">+</button>' +
'                    </div>' +
'                </div>' +
'            </div>' +
'        </div>' +
'    </div>' +
'    <div class="row mt-4">' +
'        <div class="container d-flex justify-content-center">' +
'            <button disabled id="b-reservar-hab" class="btn btn-book-a-table">' +
'                Enviar datos' +
'            </button>' +
'        </div>' +
'    </div>' +
'</form>';

$(function() {

    let loading = '<div class="loading">' + 
            '<div class="spinner"></div>' + 
            '<span class="cargando">Buscando habitaciones...</span>' + 
            '</div>';

    /**
     * Al pulsar sobre cualquier botón para reservar una habitación, se abrirá un modal con el formulario
     * necesario para la reserva
     */

    $(".div-habs-scroll").on("click", ".div-bReservarHab button", function(){
        
        let idHab = $(this).closest(".habitacion").data("value");
        let huespedes = $(this).closest(".habitacion").find(".capacidad-hab").data("value");

        $(".modal-body").empty();
        $(".modal-body").html(formHabHTML);

        $(".modal").attr("data-id", idHab);
        $("#n_huespedes").attr("max", huespedes);

        new CalendarioPlus();

        $(".modal-dialog").addClass("modal-lg");

        $(".modal .modal-title").text("Establezca las fechas para la reserva, por favor");
        abrirModal();
    });

    /**
     * Al escribir sobre cualquiera de los inputs del filtro, se realizará una búsqueda de las habitaciones
     * con los datos establecidos
     */

    $(".form-control").on("input", function() {

        $(".div-habs-scroll").empty();
        $(".div-habs-scroll").css({"overflow-y": "hidden"});
        $(".div-habs-scroll").html(loading);
        
        $.ajax({
            url: "./buscarHabitaciones", 
            type: "POST", 
            dataType: "json", 
            data: {
                capacidad: $("#capacidad").val(), 
                precio: $("#precio").val()
            }, 
            success: function(response) {
                
                $(".div-habs-scroll").empty();

                for (let habitacion of response.habitaciones) {
                    
                    var habHTML = '<div class="habitacion container" data-value="' + habitacion.id_habitacion + '">' +
                    '<div class="row">' +
                    '<div class="col-xl-12 d-flex justify-content-center gap-2">' +
                    '<div class="col-md-6 img-hab" style="background: url(http://localhost/Mejias/assets/img/habitaciones/' + habitacion.foto + '); background-position: center;"></div>' +
                    '<div class="col-md-3 d-flex flex-column justify-content-center align-items-center gap-2">' +
                    '<div class="dato-hab numero-hab">Habitación <span>' + habitacion.num_habitacion + '</span></div>' +
                    '<div class="dato-hab capacidad-hab" data-value="' + habitacion.capacidad + '">' +
                    '<i class="fa-solid fa-user-group"></i>' +
                    '<span>' + habitacion.capacidad + '</span> personas' +
                    '</div>' +
                    '<div class="dato-hab precio-hab" data-value="' + habitacion.precio + '">' +
                    '<i class="fa-solid fa-money-bill-wave"></i>' +
                    '<span>' + habitacion.precio + '€</span> / noche' +
                    '</div>' +
                    '</div>' +
                    '<div class="div-bReservarHab col-sm-2 d-flex justify-content-center align-items-center">' +
                    '<button class="btn btn-book-a-table">Reservar</button>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                    $(".div-habs-scroll").append(habHTML);
                }

                if ($(".div-habs-scroll").children().length >= 2)
                    $(".div-habs-scroll").css({"overflow-y": "scroll"});
            }
        })
    })
})

$(window).on('resize', function() {
    if ($(window).width() <= 766) {
      $('.habitacion').css({
        'background-color': 'rgba(255, 0, 0, 0.5)' // Puedes ajustar la opacidad cambiando el valor de '0.5'
      });
    } else {
      $('.habitacion').css({
        'background-color': '',
        'opacity': ''
      });
    }
  });
  