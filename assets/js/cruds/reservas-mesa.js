var id = 0;

var eliminar = '<div class="container">' +
    '<div class="row text-center">' +
    '<p>¿Estás seguro de que quieres eliminar este registro?</p>' +
    '</div>' +
    '<div class="row mt-4 d-flex justify-content-center">' +
    '<button id="btn-a-eliminar" class="btn btn-danger">\nEliminar</button>' +
    '</div>' +
    '</div>';

$(function () {

    $("#tabla-reservas-mesa").on("click", "tbody tr", function() {

        id = parseInt($(this).attr("data-index"));

        let form = formReservaMesa();
        $(".modal-title").text("Datos Reserva Mesa");
        $(".modal-body").html(form);

        $("#m-mesa").val($(this).children("td").eq(0).text());
        $("#m-estado").val($(this).children("td").eq(1).attr("data-value"));
        $("#m-email").val($(this).children("td").eq(2).attr("data-value"));
        $("#m-fecha").val($(this).children("td").eq(3).text());
        $("#m-hora").val($(this).children("td").eq(4).text());
        $("#m-comensales").val($(this).children("td").eq(5).text());

        compruebaEstado();
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

            let id_mesa = $("#m-mesa").is(":disabled") ? null : $("#m-mesa").val();

            $(this).prepend(spinner);
            $(this).attr("disabled", "true");
            $(".modal [aria-label=Close]").off("click");

            $.ajax({
                url: "./modificar-reserva-mesa", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_reserva_mesa: id, 
                    id_mesa: id_mesa, 
                    id_estado: $("#m-estado").val(), 
                    id_usuario: $("#m-email").val(), 
                    fecha: $("#m-fecha").val(), 
                    hora: $("#m-hora").val(), 
                    n_comensales: $("#m-comensales").val()
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $("#tabla-reservas-mesa tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(0).text(response.id_mesa);
                    tr.children("td").eq(1).text(response.estado);
                    tr.children("td").eq(1).attr("data-value", response.id_estado);
                    tr.children("td").eq(2).text(response.email);
                    tr.children("td").eq(2).attr("data-value", response.id_usuario);
                    tr.children("td").eq(3).text(response.fecha);
                    tr.children("td").eq(4).text(response.hora);
                    tr.children("td").eq(5).html(response.n_comensales);

                    abrirToast("Reserva Modificada con Éxito", "Puedes ver las modificaciones aplicadas en la tabla");
                    cerrarModal();
                }
            })
        })

        /**
         * Mostrar html para eliminar el registro
         */

        $("#btn-muestra-eliminar").click(function() {

            $(".modal-body").html(eliminar);
        })

        /**
         * Eliminar de forma física el registro seleccionado
         */

        $(".modal-body").on("click", "#btn-a-eliminar", function() {

            $(this).prepend(spinner);
            $(this).attr("disabled", "true");
            $(".modal [aria-label=Close]").off("click");

            $.ajax({
                url: "./eliminar-reserva-mesa", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_reserva_mesa: id
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $('#tabla-reservas-mesa tbody tr[data-index=' + id + ']');
                    table.row(':eq(' + tr.index() + ')').remove().draw();

                    abrirToast("Reserva Mesa Eliminada", "Se ha eliminado el registro de la tabla");
                    cerrarModal();
                }
            })
        })
    })

    /**
     * Si la reserva está confirmada o va a ser confirmada, se habilitará el input
     * mesa del modal. En caso contrario, se deshabilitará este input.
     */

    $(".modal-body").on("change", "#m-estado", compruebaEstado);

    /**
     * Abrir modal de creacion de nuevo registro
     */

    $(".b-crud-crear").click(function() {

        let form = formReservaMesa();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());
        form.find("#m-mesa").attr("disabled", "true");

        $(".modal-body").html(form);
        $(".modal-title").text("Crear nueva reserva de mesa");
        abrirModal();
    })

    /**
     * Crear nuevo registro
     */

    $(".modal-body").on("click", ".b-crud-crear", function() {

        let id_mesa = $("#m-mesa").is(":disabled") ? null : $("#m-mesa").val();

        $(this).prepend(spinner);
        $(this).attr("disabled", "true");
        $(".modal [aria-label=Close]").off("click");

        $.ajax({
            url: "./crear-reserva-mesa", 
            type: "POST", 
            dataType: "json", 
            data: {
                id_mesa: id_mesa, 
                id_estado: $("#m-estado").val(), 
                id_usuario: $("#m-email").val(), 
                fecha: $("#m-fecha").val(), 
                hora: $("#m-hora").val(), 
                n_comensales: $("#m-comensales").val()
            }, 
            success: function(response) {

                $(".modal [aria-label=Close]").on("click", cerrarModal);

                // Añadir nueva fila
                let newFila = table.row.add([
                    '<td>' + response.id_mesa + '</td>',
                    '<td data-value="' + response.id_estado + '">' + response.estado + '</td>',
                    '<td data-value="' + response.id_usuario + '">' + response.email + '</td>',
                    '<td>' + response.fecha + '</td>',
                    '<td>' + response.hora + '</td>',
                    '<td>' + response.n_comensales + '</td>'
                ]).draw().node();

                $(newFila).attr("data-index", response.id_reserva_mesa);
            }
        })
    })
})

// ======================= FUNCIONES =======================

/**
 * Función para crear formulario de modal
 */

function formReservaMesa() {
    let container = $('<div>').addClass('container');
    let form = $('<form>');
    let row1 = $('<div>').addClass('row mt-2');
    let col1_1 = $('<div>').addClass('col-md-6');
    let col1_2 = $('<div>').addClass('col-md-6');
    let row2 = $('<div>').addClass('row mt-2');
    let col2_1 = $('<div>').addClass('col-md-12');
    let row3 = $('<div>').addClass('row mt-2');
    let col3_1 = $('<div>').addClass('col-md-4');
    let col3_2 = $('<div>').addClass('col-md-4');
    let col3_3 = $('<div>').addClass('col-md-4');
    let row4 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').attr("disabled", "true").text('\nModificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1_1.append($('<label>').attr('for', 'm-mesa').addClass('form-label').text('Mesa Asignada'));
    col1_1.append($('<input>').attr('type', 'number').attr('name', 'm-mesa').attr('id', 'm-mesa').addClass('form-control input-modal modal-form'));
    col1_2.append($('<label>').attr('for', 'm-estado').addClass('form-label').text('Estado'));
    col1_2.append($('<select>').attr('type', 'text').attr('name', 'm-estado').attr('id', 'm-estado').addClass('form-control input-modal modal-form').html($("#estados").html()));

    row1.append(col1_1);
    row1.append(col1_2);

    col2_1.append($('<label>').attr('for', 'm-email').addClass('form-label').text('Email Usuario'));
    col2_1.append($('<select>').attr('name', 'm-email').attr('id', 'm-email').addClass('form-control input-modal modal-form').html($("#usuarios").html()));

    row2.append(col2_1);

    col3_1.append($('<label>').attr('for', 'm-fecha').addClass('form-label').text('Fecha'));
    col3_1.append($('<input>').attr('type', 'date').attr('name', 'm-fecha').attr('id', 'm-fecha').addClass('form-control input-modal modal-form'));
    col3_2.append($('<label>').attr('for', 'm-hora').addClass('form-label').text('Hora'));
    col3_2.append($('<input>').attr('type', 'time').attr('name', 'm-hora').attr('id', 'm-hora').addClass('form-control input-modal modal-form'));
    col3_3.append($('<label>').attr('for', 'm-comensales').addClass('form-label').text('Nº Comensales'));
    col3_3.append($('<input>').attr('type', 'number').attr('name', 'm-comensales').attr('id', 'm-comensales').addClass('form-control input-modal modal-form'));

    row3.append(col3_1);
    row3.append(col3_2);
    row3.append(col3_3);

    row4.append(btnModificar);
    row4.append(btnMuestraEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row4);

    container.append(form);

    return container;
}

/**
 * Función para comprobar el estado de la reserva. A partir de él, 
 * se deshabilitará o habilitará el input mesa del formulario del modal
 */

function compruebaEstado() {

    ($("#m-estado").val() == 1)
        ? $("#m-mesa").removeAttr("disabled")
        : $("#m-mesa").attr("disabled", "true")

}