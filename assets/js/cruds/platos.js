var id = 0;
var imagenCambiada = false;

var eliminar = '<div class="container">' +
    '<div class="row text-center">' +
    '<p>¿Estás seguro de que quieres eliminar este registro?</p>' +
    '</div>' +
    '<div class="row mt-4 d-flex justify-content-center">' +
    '<button id="btn-a-eliminar" class="btn btn-danger">\nEliminar</button>' +
    '</div>' +
    '</div>';

$(function() {

    $("#tabla-platos").on("click", "tbody tr", function() {

        id = parseInt($(this).attr("data-index"));
        imagenCambiada = false;

        let form = formPlato();
        $(".modal-title").text("Datos Plato");
        $(".modal-body").html(form);

        let src = $(this).children().eq(0).find('img').attr("src");
        form.find('img').attr("src", src);

        imagen = src.split("/")[src.split("/").length - 1];
        console.log(imagen);
        
        $("#m-nombre").val($(this).children("td").eq(1).text());
        $("#m-categoria").val($(this).children("td").eq(2).attr("data-value"));
        $("#m-precio-entera").val($(this).children("td").eq(3).text());
        $("#m-precio-media").val($(this).children("td").eq(4).text())

        abrirModal();

        /**
         * Al cambiar la imagen del plato, la guardaré en mi variable
         * imagen.
         */

        $("#m-imagen").change(function() {

            imagenCambiada = true;
        })

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

            let formData = new FormData();
            formData.append("id_plato", id);
            formData.append("id_categoria", $("#m-categoria").val());
            formData.append("nombre", $("#m-nombre").val());
            formData.append("precio_entera", $("#m-precio-entera").val());
            formData.append("precio_media", $("#m-precio-media").val());
            if (imagenCambiada)
                formData.append("imagen", $("#m-imagen")[0].files[0]);

            $.ajax({
                url: "./modificar-plato", 
                type: "POST", 
                dataType: "json", 
                data: formData, 
                processData: false,
                contentType: false,
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $("#tabla-platos tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(0).find("img").attr("src", "../../assets/img/platos/" + response.imagen);
                    tr.children("td").eq(1).text(response.nombre);
                    tr.children("td").eq(2).text(response.categoria);
                    tr.children("td").eq(2).attr("data-value", response.id_categoria);
                    tr.children("td").eq(3).text(response.precio_entera);
                    tr.children("td").eq(4).text(response.precio_media);

                    abrirToast("Plato Modificado con Éxito", "Puedes ver las modificaciones aplicadas en la tabla");
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
                url: "./eliminar-plato", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_plato: id
                }, 
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $('#tabla-platos tbody tr[data-index=' + id + ']');
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

        imagenCambiada = false;

        let form = formPlato();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());
        form.find("img").parent().remove();
        form.find("#m-imagen").parent().removeClass("col-md-8").addClass("col-md-12")

        $(".modal-body").html(form);
        $(".modal-title").text("Crear nuevo plato");
        abrirModal();

        $("#m-imagen").change(function() {

            imagenCambiada = true;
        })
    })

    /**
     * Crear nuevo registro
     */

    $(".modal-body").on("click", ".b-crud-crear", function() {

        $(this).prepend(spinner);
        $(this).attr("disabled", "true");
        $(".modal [aria-label=Close]").off("click");

        let formData = new FormData();
        formData.append("id_categoria", $("#m-categoria").val());
        formData.append("nombre", $("#m-nombre").val());
        formData.append("precio_entera", $("#m-precio-entera").val());
        formData.append("precio_media", $("#m-precio-media").val());
        if (imagenCambiada)
            formData.append("imagen", $("#m-imagen")[0].files[0]);

        $.ajax({
            url: "./crear-plato", 
            type: "POST", 
            dataType: "json", 
            data: formData, 
            processData: false,
            contentType: false,
            success: function(response) {

                $(".modal [aria-label=Close]").on("click", cerrarModal);
                cerrarModal();

                // Añadir nueva fila
                let newFila = table.row.add([
                    '<td><img src="../../assets/img/platos/' + response.imagen + '"></td>',
                    '<td>' + response.nombre + '</td>',
                    '<td data-value="' + response.id_categoria + '">' + response.categoria + '</td>',
                    '<td>' + response.precio_entera + '</td>', 
                    '<td>' + ((response.precio_media == null) ? 'No disponible' : response.precio_media) + '</td>'
                ]).draw().node();

                $(newFila).attr("data-index", response.id_plato);

                abrirToast("Plato creado con Éxito", "Se ha introducido el nuevo registro en la tabla");
            }
        })
    })
})

/**
 * Función para crear formulario de modal
 */

function formPlato() {

    let container = $('<div>').addClass('container plato-modal');
    let form = $('<form>').attr("enctype", "multipart/form-data");

    let row1 = $('<div>').addClass('row');
    let col1_1 = $('<div>').addClass('col-md-4 d-flex justify-content-center align-items-center');
    let col1_2 = $('<div>').addClass('col-md-8');

    let row2 = $('<div>').addClass('row mt-2');
    let col2_1 = $('<div>').addClass('col-md-6');
    let col2_2 = $('<div>').addClass('col-md-6');

    let row3 = $('<div>').addClass('row mt-2');
    let col3_1 = $('<div>').addClass('col-md-6');
    let col3_2 = $('<div>').addClass('col-md-6');

    let row4 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').attr("disabled", "true").text('\nModificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1_1.append($('<img>'));
    col1_2.append($('<label>').attr('for', 'm-imagen').addClass('form-label').text('Imagen'));
    col1_2.append($('<input>').attr('type', 'file').attr('name', 'm-imagen').attr('id', 'm-imagen').addClass('form-control input-modal modal-form'));

    row1.append(col1_1);
    row1.append(col1_2);

    col2_1.append($('<label>').attr('for', 'm-nombre').addClass('form-label').text('Nombre'));
    col2_1.append($('<input>').attr('type', 'text').attr('name', 'm-nombre').attr('id', 'm-nombre').addClass('form-control input-modal modal-form'))
    col2_2.append($('<label>').attr('for', 'm-categoria').addClass('form-label').text('Categoría'));
    col2_2.append($('<select>').attr('name', 'm-categoria').attr('id', 'm-categoria').addClass('form-control input-modal modal-form').html($("#categorias").html()));

    row2.append(col2_1);
    row2.append(col2_2);

    col3_1.append($('<label>').attr('for', 'm-precio-entera').addClass('form-label').text('Precio Ración Entera'));
    col3_1.append($('<input>').attr('type', 'number').attr('name', 'm-precio-entera').attr('id', 'm-precio-entera').addClass('form-control input-modal modal-form'))
    col3_2.append($('<label>').attr('for', 'm-precio-media').addClass('form-label').text('Precio Media Ración'));
    col3_2.append($('<input>').attr('type', 'number').attr('name', 'm-precio-media').attr('id', 'm-precio-media').addClass('form-control input-modal modal-form'));

    row3.append(col3_1);
    row3.append(col3_2);

    row4.append(btnModificar);
    row4.append(btnMuestraEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row4);

    container.append(form);

    return container;
}