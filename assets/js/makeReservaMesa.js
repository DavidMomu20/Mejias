var fechaSelected = false;
var horaSelected = false;

$(function() {
    
    new Calendario();

    $(".horas .container button.my-2").on("click", function () {
        $(".horas .container .hora-activa").removeClass("hora-activa");
        $(this).addClass("hora-activa");
    });

    $(".bMas").on("click", function () {
        let valorActual = parseInt($("#n_comensales").val());
        let valorMaximo = parseInt($("#n_comensales").attr("max"));

        if (valorActual < valorMaximo)
            $("#n_comensales").val(valorActual + 1);
    });

    $(".bMenos").on("click", function () {
        let valorActual = parseInt($("#n_comensales").val());
        let valorMinimo = parseInt($("#n_comensales").attr("min"));

        if (valorActual > valorMinimo)
            $("#n_comensales").val(valorActual - 1);
    });

    $(".calendar").on("click", ".calendar-days .calendar-day:not(.dia-inactivo)", function() {
        
        if ($(this).text().trim().length > 0) {
          
            fechaSelected = true;
            compruebaCampos();
        }
    });

    $(".horas button").click(function() {

        horaSelected = true;
        compruebaCampos();
    })
})


$("button").click(function(e) {

    e.preventDefault();
})

$("#bReservarMesa").click(function() {

    let errores = [];

    // Comprobar si se ha elegido un dia
    let fecha = $(".date-reserva").attr("data-value");
    if (fecha === "")
        errores.push("No se ha elegido una fecha");

    // Comprobar si se ha elegido una hora
    let hora = $(".hora-activa").text();
    if (hora === "")
        errores.push("No se ha elegido una hora");

    let nComensales = $("#n_comensales").val();

    if (errores.length == 0) {

        let btn = $(this);
        
        $(this).prepend(spinner);
        $(this).attr("disabled", "true");

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
                
                window.location.href = response.data;
            }
        })
    }

})

/**
 * Función para comprobar que se ha seleccionado una fecha y una hora.
 * Si se da este, se habilitará el botón para realizar la reserva
 */

function compruebaCampos() {

    if (fechaSelected && horaSelected)
       $("#bReservarMesa").removeAttr("disabled");
    else
        $("#bReservarMesa").attr("disabled", "true"); 
}