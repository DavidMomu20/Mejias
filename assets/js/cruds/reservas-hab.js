var id = 0;
var id_usuario = 0;
var puntos = 0;

var eliminar = '<div class="container">' +
    '<div class="row text-center">' +
    '<p>¿Estás seguro de que quieres eliminar este registro?</p>' +
    '</div>' +
    '<div class="row mt-4 d-flex justify-content-center">' +
    '<button id="btn-a-eliminar" class="btn btn-danger">\nEliminar</button>' +
    '</div>' +
    '</div>';

$(function() {

    $("#tabla-reservas-hab").on("click", "tbody tr", function() {

        id = parseInt($(this).attr("data-index"));

        let form = formReservaHab();
        $(".modal-title").text("Datos Reserva Habitación");
        $(".modal-body").html(form);

        $("#m-habitacion").val($(this).children("td").eq(0).attr("data-value"));
        $("#m-estado").val($(this).children("td").eq(1).attr("data-value"));
        $("#m-email").val($(this).children("td").eq(2).attr("data-value"));
        $("#m-puntos").val($(this).children("td").eq(6).text());
        $("#m-fecha-inicio").val($(this).children("td").eq(3).text());
        $("#m-fecha-fin").val($(this).children("td").eq(4).text());
        $("#m-huespedes").val($(this).children("td").eq(5).text());

        id_usuario = parseInt($("#m-email").val());
        puntos = parseInt($("#m-puntos").val());

        abrirModal();

        /**
         * Se habilitará el botón de modificar cuando se cambie los datos de
         * algún input/select del modal
         */

        $(".input-modal").change(function() {

            $("#btn-modificar").removeAttr("disabled");
        })

        /**
         * Al pulsar el botón modificar, se recogerán todos los datos 
         * del modal y se modificarán los datos en la base de datos.
         */

        $("#btn-modificar").click(function() {

            $(this).prepend(spinner);
            $(this).attr("disabled", "true");
            $(".modal [aria-label=Close]").off("click");

            $.ajax({
                url: "./modificar-reserva-hab", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_reserva_hab: id, 
                    id_habitacion: $("#m-habitacion").val(), 
                    id_estado: $("#m-estado").val(), 
                    id_usuario: $("#m-email").val(), 
                    fecha_inicio: $("#m-fecha-inicio").val(),
                    fecha_fin: $("#m-fecha-fin").val(), 
                    n_huespedes: $("#m-huespedes").val(), 
                    puntos_anteriores: puntos, 
                    puntos_usados: parseInt($("#m-puntos").val())
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $("#tabla-reservas-hab tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(0).attr("data-value", response.id_habitacion);
                    tr.children("td").eq(0).text(response.num_habitacion);
                    tr.children("td").eq(1).attr("data-value", response.id_estado);
                    tr.children("td").eq(1).text(response.estado);
                    tr.children("td").eq(2).attr("data-value", response.id_usuario);
                    tr.children("td").eq(3).text(response.fecha_inicio);
                    tr.children("td").eq(4).text(response.fecha_fin);
                    tr.children("td").eq(5).text(response.n_huespedes);
                    tr.children("td").eq(6).html(response.puntos_usados);

                    abrirToast("Reserva Modificada con Éxito", "Puedes ver las modificaciones aplicadas en la tabla");
                    cerrarModal();
                }
            })
        })

        /**
         * Mostrar html para eliminar el registro
         */

        $("#btn-muestra-eliminar").one("click", function() {

            $(".modal-body").html(eliminar);
        })

        /**
         * Eliminar de forma física el registro seleccionado
         */

        $(".modal-body").one("click", "#btn-a-eliminar", function() {

            $(this).prepend(spinner);
            $(this).attr("disabled", "true");
            $(".modal [aria-label=Close]").off("click");

            $.ajax({
                url: "./eliminar-reserva-hab", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_reserva_hab: id, 
                    id_usuario: id_usuario,
                    puntos: puntos
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $('#tabla-reservas-mesa tbody tr[data-index=' + id + ']');
                    table.row(':eq(' + tr.index() + ')').remove().draw();

                    abrirToast("Reserva Habitación Eliminada", "Se ha eliminado el registro de la tabla");
                    cerrarModal();
                }
            })
        })
    })

    /**
     * Abrir modal de creacion de nuevo registro
     */

    $(".b-crud-crear").click(function() {

        let form = formReservaHab();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());

        $(".modal-body").html(form);
        $(".modal-title").text("Crear nueva reserva de habitación");
        abrirModal();
    })

    /**
     * Crear nuevo registro
     */

    $(".modal-body").on("click", ".b-crud-crear", function() {

        $(this).prepend(spinner);
        $(this).attr("disabled", "true");
        $(".modal [aria-label=Close]").off("click");

        $.ajax({
            url: "./crear-reserva-hab", 
            type: "POST", 
            dataType: "json", 
            data: {
                id_habitacion: $("#m-habitacion").val(), 
                id_estado: $("#m-estado").val(), 
                id_usuario: $("#m-email").val(), 
                fecha_inicio: $("#m-fecha-inicio").val(),
                fecha_fin: $("#m-fecha-fin").val(), 
                n_huespedes: $("#m-huespedes").val(), 
                puntos_usados: parseInt($("#m-puntos").val())
            }, 
            success: function(response) {

                $(".modal [aria-label=Close]").on("click", cerrarModal);

                // Añadir nueva fila
                let newFila = table.row.add([
                    '<td data-value="' + response.id_habitacion + '">' + response.num_habitacion + '</td>',
                    '<td data-value="' + response.id_estado + '">' + response.estado + '</td>',
                    '<td data-value="' + response.id_usuario + '">' + response.email + '</td>',
                    '<td>' + response.fecha_inicio + '</td>',
                    '<td>' + response.fecha_fin + '</td>',
                    '<td>' + response.n_huespedes + '</td>',
                    '<td>' + response.puntos_usados + '</td>'
                ]).draw().node();

                $(newFila).attr("data-index", response.id_reserva_hab);
            }
        })
    })

})

// ======================= FUNCIONES =======================

/**
 * Función para crear formulario de modal
 */

function formReservaHab() {
    let container = $('<div>').addClass('container');
    let form = $('<form>');
    let row1 = $('<div>').addClass('row mt-2');
    let col1_1 = $('<div>').addClass('col-md-6');
    let col1_2 = $('<div>').addClass('col-md-6');
    let row2 = $('<div>').addClass('row mt-2');
    let col2_1 = $('<div>').addClass('col-md-6');
    let col2_2 = $("<div>").addClass('col-md-6');
    let row3 = $('<div>').addClass('row mt-2');
    let col3_3 = $('<div>').addClass('col-md-12');
    let row5 = $('<div>').addClass('row mt-2');
    let col5_1 = $('<div>').addClass('col-md-6');
    let col5_2 = $('<div>').addClass('col-md-6');
    let row4 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').attr("disabled", "true").text('\nModificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1_1.append($('<label>').attr('for', 'm-habitacion').addClass('form-label').text('Habitación'));
    col1_1.append($('<select>').attr('name', 'm-habitacion').attr('id', 'm-habitacion').addClass('form-control input-modal modal-form').html($("#habitaciones").html()));
    col1_2.append($('<label>').attr('for', 'm-estado').addClass('form-label').text('Estado'));
    col1_2.append($('<select>').attr('type', 'text').attr('name', 'm-estado').attr('id', 'm-estado').addClass('form-control input-modal modal-form').html($("#estados").html()));

    row1.append(col1_1);
    row1.append(col1_2);

    col2_1.append($('<label>').attr('for', 'm-email').addClass('form-label').text('Email Usuario'));
    col2_1.append($('<select>').attr('name', 'm-email').attr('id', 'm-email').addClass('form-control input-modal modal-form').html($("#usuarios").html()));
    col2_2.append($('<label>').attr('for', 'm-puntos').addClass('form-label').text("Puntos Usados"));
    col2_2.append($('<input>').attr('type', 'number').attr('name', 'm-puntos').attr('id', 'm-puntos').addClass('form-control input-modal modal-form'))

    row2.append(col2_1);
    row2.append(col2_2);

    col3_3.append($('<label>').attr('for', 'm-huespedes').addClass('form-label').text('Nº Huéspedes'));
    col3_3.append($('<input>').attr('type', 'number').attr('name', 'm-huespedes').attr('id', 'm-huespedes').addClass('form-control input-modal modal-form'));

    row3.append(col3_3);

    col5_1.append($('<label>').attr('for', 'm-fecha-inicio').addClass('form-label').text('Fecha de entrada'));
    col5_1.append($('<input>').attr('type', 'date').attr('name', 'm-fecha-inicio').attr('id', 'm-fecha-inicio').addClass('form-control input-modal modal-form'));
    col5_2.append($('<label>').attr('for', 'm-fecha-fin').addClass('form-label').text('Fecha de salida'));
    col5_2.append($('<input>').attr('type', 'date').attr('name', 'm-fecha-fin').attr('id', 'm-fecha-fin').addClass('form-control input-modal modal-form'));

    row5.append(col5_1);
    row5.append(col5_2);

    row4.append(btnModificar);
    row4.append(btnMuestraEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row5);
    form.append(row3);
    form.append(row4);

    container.append(form);

    return container;
}