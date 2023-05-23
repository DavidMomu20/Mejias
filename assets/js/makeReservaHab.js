$(function() {

    $(".modal-body").on("click", ".bMas", function () {
        let valorActual = parseInt($("#n_huespedes").val());
        let valorMaximo = parseInt($("#n_huespedes").attr("max"));

        if (valorActual < valorMaximo)
            $("#n_huespedes").val(valorActual + 1);
    });

    $(".modal-body").on("click", ".bMenos", function () {
        let valorActual = parseInt($("#n_huespedes").val());
        let valorMinimo = parseInt($("#n_huespedes").attr("min"));

        if (valorActual > valorMinimo)
            $("#n_huespedes").val(valorActual - 1);
    });

    /**
     * Al pulsar sobre el botón b-reservar-hab, se introducirá la reserva de la habitación en la base de datos
     */

    $(".modal-body").on("click", "#b-reservar-hab", function(e) {

        e.preventDefault();

        let btn = $(this);
        let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        
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
                id_habitacion: $(".modal").data("id")
            }, 
            success: function(response) {

                btn.find(".spinner-border").remove();
                btn.removeAttr("disabled");

                console.log(response.data);
            }
        })
    })
})