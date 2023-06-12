$(function() {

    $(".modal-body").on("click", ".bMas", function () {
        let input = $(this).siblings('.my-input-number');
        
        let valorActual = parseInt(input.val());
        let valorMaximo = parseInt(input.attr("max"));

        if (valorActual < valorMaximo)
            input.val(valorActual + 1);
    });

    $(".modal-body").on("click", ".bMenos", function () {
        let input = $(this).siblings('.my-input-number');

        let valorActual = parseInt(input.val());
        let valorMinimo = parseInt(input.attr("min"));

        if (valorActual > valorMinimo)
            input.val(valorActual - 1);
    });

    /**
     * Al pulsar sobre el botón b-reservar-hab, se introducirá la reserva de la habitación en la base de datos
     */

    $(".modal-body").on("click", "#b-reservar-hab", function(e) {

        e.preventDefault();

        let btn = $(this);
        
        $(this).prepend(spinner);
        $(this).attr("disabled", "true");

        $.ajax({
            url: "./reservarHab", 
            type: "POST", 
            dataType: "json", 
            data: {
                fecha_inicio: $("#fecha-inicio-input").attr("data-value"), 
                fecha_fin: $("#fecha-fin-input").attr("data-value"), 
                n_huespedes: $("#n_huespedes").val(), 
                id_habitacion: $(".modal").data("id"),
                puntos_usados: $("#puntos").val()
            }, 
            success: function(response) {

                btn.find(".spinner-border").remove();
                btn.removeAttr("disabled");

                console.log(response.data);
            }
        })
    })
})