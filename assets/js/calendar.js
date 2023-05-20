$(document).ready(function () {
    var date = new Date();
    var month = date.getMonth();
    var year = date.getFullYear();
    var months = ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"];

    $(".prev-month").click(function () {
        var calendar = $(this).closest('.calendar');
        var monthElement = calendar.find('.current-month-year');
        var month = monthElement.data('month');
        var year = monthElement.data('year');

        if (month === 0) {
            month = 11;
            year--;
        } else {
            month--;
        }
        updateCalendar(calendar, month, year);
    });

    $(".next-month").click(function () {
        var calendar = $(this).closest('.calendar');
        var monthElement = calendar.find('.current-month-year');
        var month = monthElement.data('month');
        var year = monthElement.data('year');

        if (month === 11) {
            month = 0;
            year++;
        } else {
            month++;
        }
        updateCalendar(calendar, month, year);
    });

    function updateCalendar(calendar, month, year) {
        var monthElement = calendar.find('.current-month-year');
        monthElement.data('month', month);
        monthElement.data('year', year);

        monthElement.text(months[month] + " " + year);
        calendar.find(".calendar-days").empty();

        // Obtener el primer día del mes y el número de días en el mes
        var firstDay = new Date(year, month, 1).getDay();
        var daysInMonth = new Date(year, month + 1, 0).getDate();

        // Ajustar los días del calendario para que correspondan al día de la semana correcto
        for (var i = 0; i < firstDay; i++) {
            calendar.find('.calendar-days').append('<div class="calendar-day"></div>');
        }

        for (var i = 1; i <= daysInMonth; i++) {
            var day = $('<div class="calendar-day">' + i + '</div>');
            calendar.find('.calendar-days').append(day);
            day.click(escribeFecha);
        }
    }

    function escribeFecha() {
        var diaSeleccionado = $(this).text();
        var diaActivo = $(".dia-activo");

        if (diaActivo.length > 0) {
            diaActivo.removeClass("dia-activo");
        }

        $(this).addClass("dia-activo");

        var year = new Date().getFullYear();
        var month = new Date().getMonth();
        var fechaSeleccionada = new Date(year, month, diaSeleccionado);

        var diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        var nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $(".date-reserva").text(diasSemana[fechaSeleccionada.getDay()] + ", " + fechaSeleccionada.getDate() +
                                 " de " + nombreMeses[fechaSeleccionada.getMonth()] + " " + fechaSeleccionada.getFullYear());

        var formattedDate = fechaSeleccionada.getFullYear() + '-' +
                ('0' + (fechaSeleccionada.getMonth() + 1)).slice(-2) + '-' +
                ('0' + fechaSeleccionada.getDate()).slice(-2);
        $(".date-reserva").attr("data-value", formattedDate);
    }

    updateCalendar($(".reserva-calendario .calendar"), month, year);
    updateCalendar($(".reserva-horas .calendar"), month, year);

    $(".horas .container button.my-2").on("click", function() {
        $(".horas .container .hora-activa").removeClass("hora-activa");
        $(this).addClass("hora-activa");
    });

    $(".bMas").on("click", function() {
        var valorActual = parseInt($("#n_comensales").val());
        var valorMaximo = parseInt($("#n_comensales").attr("max"));

        if (valorActual < valorMaximo)
            $("#n_comensales").val(valorActual + 1); 
    });

    $(".bMenos").on("click", function() {
        var valorActual = parseInt($("#n_comensales").val());
        var valorMinimo = parseInt($("#n_comensales").attr("min"));

        if (valorActual > valorMinimo)
            $("#n_comensales").val(valorActual - 1); 
    });
});