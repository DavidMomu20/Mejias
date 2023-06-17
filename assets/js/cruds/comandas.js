var id = 0;

var eliminar = '<div class="container">' +
    '<div class="row text-center">' +
    '<p>¿Estás seguro de que quieres eliminar este registro?</p>' +
    '</div>' +
    '<div class="row mt-4 d-flex justify-content-center">' +
    '<button id="btn-a-eliminar" class="btn btn-danger">\nEliminar</button>' +
    '</div>' +
    '</div>';

$(function() {

    $("#tabla-comandas").on("click", "tbody tr", function() {

        id = parseInt($(this).attr("data-index"));

        let form = formComanda();
        $(".modal-title").text("Datos Comanda");
        $(".modal-body").html(form);

        $("#m-precio-total").val($(this).children("td").eq(3).text());
        $("#m-fecha").val($(this).children("td").eq(1).text());
        $("#m-hora").val($(this).children("td").eq(2).text());

        abrirModal();

        /**
         * Se habilitará el botón de modificar cuando se cambie los datos de
         * algún input/select del modal
         */

        $(".input-modal").change(function() {

            if ($("#m-mesa").val() != undefined)
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
                url: "./modificar-comanda", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_comanda: id, 
                    id_mesa: $("#m-mesa").val(), 
                    fecha: $("#m-fecha").val(), 
                    hora: $("#m-hora").val()
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $("#tabla-comandas tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(0).text(response.id_mesa);
                    tr.children("td").eq(0).attr("data-value", response.id_mesa);
                    tr.children("td").eq(1).text(response.fecha);
                    tr.children("td").eq(2).text(response.hora);
                    tr.children("td").eq(3).text(response.precio_total);

                    abrirToast("Comanda Modificada con Éxito", "Puedes ver las modificaciones aplicadas en la tabla");
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
                url: "./eliminar-comanda", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_comanda: id
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $('#tabla-comandas tbody tr[data-index=' + id + ']');
                    table.row(':eq(' + tr.index() + ')').remove().draw();

                    abrirToast("Comanda Eliminada", "Se ha eliminado el registro de la tabla");
                    cerrarModal();
                }
            })
        })
    })

    /**
     * Abrir modal de creacion de nuevo registro
     */

    $(".b-crud-crear").click(function() {

        let form = formComanda();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());
        form.find("#m-precio-total").val("0");
        form.find("#m-precio-total").removeAttr("readonly");

        $(".modal-body").html(form);
        $(".modal-title").text("Crear nueva comanda");
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
            url: "./crear-comanda", 
            type: "POST", 
            dataType: "json", 
            data: {
                id_mesa: $("#m-mesa").val(), 
                fecha: $("#m-fecha").val(), 
                hora: $("#m-hora").val(), 
                precio_total: $("#m-precio-total").val()
            }, 
            success: function(response) {

                $(".modal [aria-label=Close]").on("click", cerrarModal);
                cerrarModal();

                // Añadir nueva fila
                let newFila = table.row.add([
                    '<td data-value="' + response.id_mesa + '">' + response.id_mesa + '</td>',
                    '<td>' + response.fecha + '</td>',
                    '<td>' + response.hora + '</td>',
                    '<td>' + response.precio_total + '</td>'
                ]).draw().node();

                $(newFila).attr("data-index", response.id_comanda);

                abrirToast("Comanda creado con Éxito", "Se ha introducido el nuevo registro en la tabla");
            }
        })
    })
})

// ======================= FUNCIONES =======================

/**
 * Función para crear formulario de modal
 */

function formComanda() {

    let container = $('<div>').addClass('container');
    let form = $('<form>');

    let row1 = $('<div>').addClass('row mt-2');
    let col1_1 = $('<div>').addClass('col-md-6');
    let col1_2 = $('<div>').addClass('col-md-6');

    let row2 = $('<div>').addClass('row mt-2');
    let col2_1 = $('<div>').addClass('col-md-6');
    let col2_2 = $('<div>').addClass('col-md-6');

    let row3 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').attr("disabled", "true").text('\nModificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1_1.append($('<label>').attr('for', 'm-fecha').addClass('form-label').text('Fecha'));
    col1_1.append($('<input>').attr('type', 'date').attr('name', 'm-fecha').attr('id', 'm-fecha').addClass('form-control input-modal modal-form'));
    col1_2.append($('<label>').attr('for', 'm-hora').addClass('form-label').text('Hora'));
    col1_2.append($('<input>').attr('type', 'time').attr('name', 'm-hora').attr('id', 'm-hora').addClass('form-control input-modal modal-form'));

    row1.append(col1_1);
    row1.append(col1_2);

    col2_1.append($('<label>').attr('for', 'm-mesa').addClass('form-label').text('Mesa Asignada'));
    col2_1.append($('<select>').attr('name', 'm-mesa').attr('id', 'm-mesa').addClass('form-control input-modal modal-form').html($("#mesas").html()));
    col2_2.append($('<label>').attr('for', 'm-precio-total').addClass('form-label').text('Precio Total'));
    col2_2.append(
        $('<div>').addClass('input-group').append(
            $('<input>').attr('type', 'number').attr('min', '1').attr('step', 'any').attr('readonly', 'true').attr('name', 'm-precio-total').attr('id', 'm-precio-total').addClass('form-control input-modal modal-form'),
            $('<span>').addClass('input-group-text').text('€')
        )
    );

    row2.append(col2_1);
    row2.append(col2_2);

    row3.append(btnModificar);
    row3.append(btnMuestraEliminar);

    form.append(row2);
    form.append(row1);
    form.append(row3);

    container.append(form);

    return container;
}