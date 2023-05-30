/**
 * Clase Calendario
 * 
 * -- Esta clase crea un calendario en el cual puedes escoger una fecha determinada. 
 * -- Con este calendario podremos establecer las fechas para la reserva.
 */

class Calendario {
    constructor() {
        this.months = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];

        this.currentDate = new Date();
        this.month = this.currentDate.getMonth();
        this.year = this.currentDate.getFullYear();

        this.initialize();
    }

    initialize() {
        $(".prev-month").click(() => {
            const currentDate = new Date(); // Obtener la fecha actual
            const currentMonth = currentDate.getMonth();
            const currentYear = currentDate.getFullYear();

            if (
                this.year < currentYear ||
                (this.year === currentYear && this.month > currentMonth)
            ) {
                // El mes al que vamos a cambiar es igual o posterior al mes actual
                this.month = this.month === 0 ? 11 : this.month - 1;
                this.year = this.month === 11 ? this.year + 1 : this.year;
                this.updateCalendar();
            }
        });

        $(".next-month").click(() => {
            this.month = this.month === 11 ? 0 : this.month + 1;
            this.year = this.month === 0 ? this.year + 1 : this.year;
            this.updateCalendar();
        });

        this.updateCalendar();
    }

    updateCalendar() {
        const calendarDays = $(".calendar-days");
        const calendarDayElements = [];

        calendarDays.empty();

        const firstDay = new Date(this.year, this.month, 1).getDay();
        const daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
        const currentDate = new Date();
        currentDate.setHours(0, 0, 0, 0); // Establecer la hora a 00:00:00:00

        for (let i = 0; i < firstDay; i++) {
            calendarDayElements.push('<div class="calendar-day"></div>');
        }

        for (let i = 1; i <= daysInMonth; i++) {
            const selectedDate = new Date(this.year, this.month, i);
            const day = $(
                '<div class="calendar-day">' + i + "</div>"
            ).click(this.escribeFecha);

            day.toggleClass("dia-inactivo", selectedDate < currentDate);
            calendarDayElements.push(day);
        }

        calendarDays.append(calendarDayElements);
        $("span.current-month-year")
            .attr("data-month", this.month)
            .attr("data-year", this.year)
            .text(this.months[this.month] + " " + this.year);
    }

    escribeFecha() {
        const diaSeleccionado = $(this).text();
        const diaActivo = $(".dia-activo");
        const year = parseInt($("span.current-month-year").attr("data-year"));
        const month = parseInt($("span.current-month-year").attr("data-month"));
        const fechaSeleccionada = new Date(year, month, diaSeleccionado);

        // Obtener la fecha actual
        const fechaHoy = new Date();
        fechaHoy.setHours(0, 0, 0, 0); // Establecer la hora a las 00:00:00 para la comparación

        if (fechaSeleccionada < fechaHoy) {
            return; // Si la fecha seleccionada es anterior a la fecha actual, no se agrega la clase "dia-activo"
        }

        diaActivo.removeClass("dia-activo");
        $(this).addClass("dia-activo");

        const diasSemana = [
            "Domingo",
            "Lunes",
            "Martes",
            "Miércoles",
            "Jueves",
            "Viernes",
            "Sábado",
        ];
        const nombreMeses = [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
        ];

        $(".date-reserva").text(
            diasSemana[fechaSeleccionada.getDay()] +
            ", " +
            fechaSeleccionada.getDate() +
            " de " +
            nombreMeses[fechaSeleccionada.getMonth()] +
            " " +
            fechaSeleccionada.getFullYear()
        );

        const formattedDate =
            fechaSeleccionada.getFullYear() +
            "-" +
            ("0" + (fechaSeleccionada.getMonth() + 1)).slice(-2) +
            "-" +
            ("0" + fechaSeleccionada.getDate()).slice(-2);
        $(".date-reserva").attr("data-value", formattedDate);
    }
}


/**
 * Clase CalendarioPlus 
 * 
 * -- Clase que hereda de Calendario.
 * -- Se le han agregado nuevas funcionalidades, necesarias para la reserva de habitaciones
 */

class CalendarioPlus extends Calendario {

    constructor() {
        super();
    }

    escribeFecha() {
        const diaSeleccionado = $(this).text();
        const year = parseInt($("span.current-month-year").attr("data-year"));
        const month = parseInt($("span.current-month-year").attr("data-month"));
        const fechaSeleccionada = new Date(year, month, diaSeleccionado);
        const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        const nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const formattedDate = fechaSeleccionada.getFullYear() + '-' + ('0' + (fechaSeleccionada.getMonth() + 1)).slice(-2) + '-' + ('0' + fechaSeleccionada.getDate()).slice(-2);

        let diaActivo = $(".dia-activo");
        let diaFinActivo = $(".dia-fin-activo");

        if (diaActivo.length > 0 && diaFinActivo.length > 0) {
            $(".dia-activo").removeClass("dia-activo");
            $(".dia-fin-activo").removeClass("dia-fin-activo");

            $(this).addClass("dia-activo");

            $("#fecha-fin-input").val("");
            $("#fecha-fin-input").removeAttr("data-value");

            $("#fecha-inicio-input").val(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`)
            $("#fecha-inicio-input").attr("data-value", formattedDate);

            $("#b-reservar-hab").attr("disabled", "true");
        }
        else {
            if (diaActivo.length > 0) {
                $(this).addClass("dia-fin-activo");

                $("#fecha-fin-input").val(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`);
                $("#fecha-fin-input").attr("data-value", formattedDate);

                $("#b-reservar-hab").removeAttr("disabled");
            }
            else {
                $(this).addClass("dia-activo");

                $("#fecha-inicio-input").val(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`);
                $("#fecha-inicio-input").attr("data-value", formattedDate);
            }
        }
    }
}