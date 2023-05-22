/**
 * Clase Calendario
 * 
 * -- Esta clase crea un calendario en el cual puedes escoger una fecha determinada. 
 * -- Con este calendario podremos establecer las fechas para la reserva.
 */

var diaInicio = true;

class Calendario {

    constructor() {
        this.months = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
        
        this.currentDate = new Date();
        this.month = this.currentDate.getMonth();
        this.year = this.currentDate.getFullYear();

        this.initialize();
    }

    initialize() {
        $(".prev-month").click(() => {
            if (this.month === 0) {
                this.month = 11;
                this.year--;
            } else {
                this.month--;
            }
            this.updateCalendar();
        });

        $(".next-month").click(() => {
            if (this.month === 11) {
                this.month = 0;
                this.year++;
            } else {
                this.month++;
            }
            this.updateCalendar();
        });

        this.updateCalendar();
    }

    updateCalendar() {
        let monthElement = $(".current-month-year");
        monthElement.data('month', this.month);
        monthElement.data('year', this.year);

        monthElement.text(this.months[this.month] + " " + this.year);
        $(".calendar-days").empty();

        let firstDay = new Date(this.year, this.month, 1).getDay();
        let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            $('.calendar-days').append('<div class="calendar-day"></div>');
        }

        for (let i = 1; i <= daysInMonth; i++) {
            let day = $('<div class="calendar-day">' + i + '</div>');
            $('.calendar-days').append(day);
            day.click(this.escribeFecha);
        }
    }

    escribeFecha() {
        let diaSeleccionado = $(this).text();
        let diaActivo = $(".dia-activo");

        if (diaActivo.length > 0) {
            diaActivo.removeClass("dia-activo");
        }

        $(this).addClass("dia-activo");

        let year = new Date().getFullYear();
        let month = new Date().getMonth();
        fechaSeleccionada = new Date(year, month, diaSeleccionado);

        let diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        let nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        $(".date-reserva").text(diasSemana[fechaSeleccionada.getDay()] + ", " + fechaSeleccionada.getDate() +
            " de " + nombreMeses[fechaSeleccionada.getMonth()] + " " + fechaSeleccionada.getFullYear());

        let formattedDate = fechaSeleccionada.getFullYear() + '-' +
            ('0' + (fechaSeleccionada.getMonth() + 1)).slice(-2) + '-' +
            ('0' + fechaSeleccionada.getDate()).slice(-2);
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
        const year = new Date().getFullYear();
        const month = new Date().getMonth();
        const fechaSeleccionada = new Date(year, month, diaSeleccionado);
        const diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        const nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        const formattedDate = fechaSeleccionada.getFullYear() + '-' + ('0' + (fechaSeleccionada.getMonth() + 1)).slice(-2) + '-' + ('0' + fechaSeleccionada.getDate()).slice(-2);

        let diaActivo = $(".dia-activo");
        let diaFinActivo = $(".dia-fin-activo");

        console.log(diaActivo.length + " - " + diaFinActivo.length);

        if (diaActivo.length > 0 && diaFinActivo.length > 0) {
            $(".dia-activo").removeClass("dia-activo");
            $(".dia-fin-activo").removeClass("dia-fin-activo");

            $(this).addClass("dia-activo");

            $(".fecha-inicio-reserva").text(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`);
            $(".fecha-inicio-reserva").attr("data-value", formattedDate);

            $(".fecha-fin-reserva").text("Sin definir");
            $(".fecha-fin-reserva").removeAttr("data-value");
        }
        else {
            if (diaActivo.length > 0) {
                $(this).addClass("dia-fin-activo");

                $(".fecha-fin-reserva").text(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`);
                $(".fecha-fin-reserva").attr("data-value", formattedDate);
            }
            else {
                $(this).addClass("dia-activo");

                $(".fecha-inicio-reserva").text(`${diasSemana[fechaSeleccionada.getDay()]}, ${fechaSeleccionada.getDate()} de ${nombreMeses[fechaSeleccionada.getMonth()]} ${fechaSeleccionada.getFullYear()}`);
                $(".fecha-inicio-reserva").attr("data-value", formattedDate);
            }
        }
    }
}