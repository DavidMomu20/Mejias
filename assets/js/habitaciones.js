$(function() {

    let loading = '<div class="loading">' + 
            '<div class="spinner"></div>' + 
            '<span class="cargando">Buscando habitaciones...</span>' + 
            '</div>';

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
                    
                    let habHTML = '<div class="habitacion" data-value="' + habitacion.id_habitacion + '">' +
                        '<div class="datos-habitacion">' +
                        '<div class="image" style="background: url(\'assets/img/habitaciones/' + habitacion.foto + '\')"></div>' +
                        '<div class="datos">' +
                        '<div class="dato-hab numero-hab"><span>Habitación</span> ' + habitacion.num_habitacion + '</div>' +
                        '<div class="dato-hab capacidad-hab" data-value="' + habitacion.capacidad + '">' +
                        '<i class="fa-solid fa-user-group"></i>' +
                        '<span>' + habitacion.capacidad + ' personas</span>' +
                        '</div>' +
                        '<div class="dato-hab precio-hab" data-value="' + habitacion.precio + '">' +
                        '<i class="fa-solid fa-money-bill-wave"></i>' +
                        '<span>' + habitacion.precio + '€ / noche</span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="div-bReservarHab">' +
                        '<button class="btn btn-book-a-table">Reservar</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $(".div-habs-scroll").append(habHTML);
                }

                if ($(".div-habs-scroll").children().length >= 4)
                    $(".div-habs-scroll").css({"overflow-y": "scroll"});
            }
        })
    })
})