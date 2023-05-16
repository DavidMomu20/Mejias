$(document).ready(function () {
    var date = new Date();
    var month = date.getMonth();
    var year = date.getFullYear();
    var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

    $(".current-month-year").text(months[month] + " " + year);

    $(".prev-month").click(function () {
        if (month === 0) {
            month = 11;
            year--;
        } else {
            month--;
        }
        updateCalendar();
    });

    $(".next-month").click(function () {
        if (month === 11) {
            month = 0;
            year++;
        } else {
            month++;
        }
        updateCalendar();
    });

    function updateCalendar() {
        $(".current-month-year").text(months[month] + " " + year);
        $(".calendar-days").empty();
    
        // Obtener el primer día del mes y el número de días en el mes
        var firstDay = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();
    
        // Ajustar los días del calendario para que correspondan al día de la semana correcto
        for (var i = 0; i < firstDay; i++) {
          $(".calendar-days").append('<div class="calendar-day"></div>');
        }
    
        for (var i = 1; i <= daysInMonth; i++) {
          var day = $('<div class="calendar-day">' + i + '</div>');
          $(".calendar-days").append(day);
          day.click(escribeFecha);
        }
      }

    updateCalendar();

    function escribeFecha() {

        // Buscar si hay algún td con la clase "dia-activo"
        let diaActivo = $(".dia-activo");
        // Si se encuentra, eliminar la clase
        if (diaActivo.length > 0) {
            diaActivo.removeClass("dia-activo");
        }

        $(this).addClass("dia-activo");

        let fechaSeleccionada = new Date(year, month, $(this).text())

        let diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        let nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $(".date-reserva").text(diasSemana[fechaSeleccionada.getDay()] + ", " + fechaSeleccionada.getDate() +
                             " de " + nombreMeses[fechaSeleccionada.getMonth()] + " " + fechaSeleccionada.getFullYear())

        $(".date-reserva").attr("data-value", fechaSeleccionada.toISOString().substring(0, 10));
    }

    $(".horas .container button.my-2").on("click", function() {

        $(".horas .container .hora-activa").removeClass("hora-activa");
        $(this).addClass("hora-activa");
    })

    $(".bMas").on("click", function() {
        let valorActual = parseInt($("#n_comensales").val());
        let valorMaximo = parseInt($("#n_comensales").attr("max"));

        if (valorActual < valorMaximo)
            $("#n_comensales").val(valorActual + 1); 
    })

    $(".bMenos").on("click", function() {
        let valorActual = parseInt($("#n_comensales").val());
        let valorMinimo = parseInt($("#n_comensales").attr("min"));

        if (valorActual > valorMinimo)
            $("#n_comensales").val(valorActual - 1); 
    })
});

// fechaSeleccionada.toLocaleDateString(); para formato "d/m/Y"