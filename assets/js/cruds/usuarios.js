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

    /**
     * Cuando se pulsa un registro, se abrirá un modal con todos sus datos, 
     * además de los botones modificar y eliminar.
     */

    $("#tabla-usuarios").on("click", "tbody tr", function () {

        id = parseInt($(this).attr("data-index"));

        let form = formUsuario();
        $(".modal-body").html(form);

        $("#nombre-modal").val($(this).children("td").eq(0).text());
        $("#apellido-modal").val($(this).children("td").eq(1).text());
        $("#rol-modal").val($(this).children("td").eq(2).attr("data-value"));
        $("#puntos-modal").val($(this).children("td").eq(5).text());
        $("#correo-modal").val($(this).children("td").eq(3).text());
        $("#telefono-modal").val($(this).children("td").eq(4).text());

        compruebaRol();
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

            let puntos = $("#puntos-modal").is(":disabled") ? null : $("#puntos-modal").val();
            let btn = $(this);

            btn.prepend(spinner);
            btn.attr("disabled", "true");

            $.ajax({
                url: "./modificar-usuario", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_usuario: id, 
                    id_rol: $("#rol-modal").val(), 
                    nombre: $("#nombre-modal").val(), 
                    apellido: $("#apellido-modal").val(), 
                    email: $("#correo-modal").val(), 
                    telefono: $("#telefono-modal").val(), 
                    puntos: puntos
                }, 
                success: function(response) {

                    let puntos = response.puntos;
                    if (puntos === null)
                        puntos = "<i>No tiene</i>";

                    let tr = $("#tabla-usuarios tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(0).text(response.nombre);
                    tr.children("td").eq(1).text(response.apellido);
                    tr.children("td").eq(2).text(response.rol)
                    tr.children("td").eq(2).attr("data-value", response.id_rol)
                    tr.children("td").eq(3).text(response.email);
                    tr.children("td").eq(4).text(response.telefono);
                    tr.children("td").eq(5).html(puntos);

                    abrirToast("Usuario Modificado con Éxito", "Puedes ver las modificaciones aplicadas en la tabla");
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
         * Eliminar de forma lógica el registro seleccionado
         */

        $(".modal-body").on("click", "#btn-a-eliminar", function() {

            $(this).prepend(spinner);
            $(this).attr("disabled", "true");
            $(".modal [aria-label=Close]").off("click");

            $.ajax({
                url: "./eliminar-usuario", 
                type: "POST", 
                dataType: "json", 
                data: {
                    id_usuario: id
                },
                success: function(response) {

                    $(".modal [aria-label=Close]").on("click", cerrarModal);

                    let tr = $("#tabla-usuarios tbody tr[data-index='" + id + "']");
                    tr.children("td").eq(6).text("Si");
                    
                    abrirToast("Usuario Eliminado", "Puedes ver los cambios en la tabla");
                    cerrarModal();
                }
            })
        })
    })

    /**
     * Abrir modal de creacion de nuevo registro
     */

    $(".b-crud-crear").click(function() {

        let form = formUsuario();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());
        form.find("#puntos-modal").attr("disabled", "true");
        form.find(".row-password").removeClass("d-none");

        $(".modal-body").html(form);
        $(".modal-title").text("Crear nuevo usuario");
        abrirModal();
    })

    /**
     * Crear nuevo registro
     */

    $(".modal-body").on("click", ".b-crud-crear", function() {

        let puntos = $("#puntos-modal").is(":disabled") ? null : $("#puntos-modal").val();
        
        $(this).prepend(spinner);
        $(this).attr("disabled", "true");
        $(".modal [aria-label=Close]").off("click");

        $.ajax({
            url: "./crear-usuario", 
            type: "POST", 
            dataType: "json", 
            data: {
                id_rol: $("#rol-modal").val(), 
                nombre: $("#nombre-modal").val(), 
                apellido: $("#apellido-modal").val(), 
                email: $("#correo-modal").val(), 
                password: $("#password-modal").val(),
                telefono: $("#telefono-modal").val(), 
                puntos: puntos
            }, 
            success: function(response) {

                $(".modal [aria-label=Close]").on("click", cerrarModal);

                let puntos = response.puntos;
                if (puntos === null);
                    puntos = "<i>No tiene</i>";

                // Añadir nueva fila
                let newFila = table.row.add([
                    '<td>' + response.nombre + '/td>',
                    '<td>' + response.apellido + '</td>',
                    '<td data-value="' + response.id_rol + '">' + response.rol + '</td>',
                    '<td>' + response.email + '</td>',
                    '<td>' + response.telefono + '</td>',
                    '<td>' + puntos + '</td>',
                    '<td>No</td>'
                ]).draw().node();

                $(newFila).attr("data-index", response.id_usuario);
            }
        })
    })

    /**
     * Si el usuario es cliente, podrá establecer el nº de puntos que tendrá.
     * De lo contrario, el input de puntos del modal se deshabilitará y su valor
     * será nulo.
     */

    $(".modal-body").on("change", "#rol-modal", compruebaRol)
})

// ======================= FUNCIONES =======================

/**
 * Función que crea el formulario de modal para usuarios
 */

function formUsuario() {
    let container = $('<div>').addClass('container');
    let form = $('<form>');
    let row1 = $('<div>').addClass('row');
    let row2 = $('<div>').addClass('row mt-2');
    let row3 = $('<div>').addClass('row mt-2');
    let row4 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let row5 = $('<div>').addClass('row-password row mt-2 d-none');
    let col1 = $('<div>').addClass('col-md-6 text-center');
    let col2 = $('<div>').addClass('col-md-6 text-center');
    let col3 = $('<div>').addClass('col-md-6 text-center');
    let col4 = $('<div>').addClass('col-md-6 text-center');
    let col5 = $('<div>').addClass('col-md-6 text-center');
    let col6 = $('<div>').addClass('col-md-6 text-center');
    let col7 = $('<div>').addClass('col-md-12 text-center')
    let btnModificar = $('<button>').attr("type", "button").attr('disabled', true).addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').text('\nModificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1.append($('<label>').attr('for', 'nombre-modal').addClass('form-label').text('Nombre:'));
    col1.append($('<input>').attr('type', 'text').attr('id', 'nombre-modal').attr('name', 'nombre-modal').addClass('input-modal form-control'));
    col2.append($('<label>').attr('for', 'apellido-modal').addClass('form-label').text('Apellido:'));
    col2.append($('<input>').attr('type', 'text').attr('id', 'apellido-modal').attr('name', 'apellido-modal').addClass('input-modal form-control'));

    row1.append(col1);
    row1.append(col2);

    col3.append($('<label>').attr('for', 'rol-modal').addClass('form-label').text('Rol:'));
    col3.append($('<select>').attr('id', 'rol-modal').attr('name', 'rol-modal').addClass('input-modal form-control').html($("#roles").html()));
    col4.append($('<label>').attr('for', 'puntos-modal').addClass('form-label').text('Puntos:'));
    col4.append($('<input>').attr('type', 'text').attr('id', 'puntos-modal').attr('name', 'puntos-modal').addClass('input-modal form-control'));

    row2.append(col3);
    row2.append(col4);

    col5.append($('<label>').attr('for', 'correo-modal').addClass('form-label').text('Correo electrónico:'));
    col5.append($('<input>').attr('type', 'text').attr('id', 'correo-modal').attr('name', 'correo-modal').addClass('input-modal form-control'));
    col6.append($('<label>').attr('for', 'telefono-modal').addClass('form-label').text('Nº Teléfono:'));
    col6.append($('<input>').attr('type', 'text').attr('id', 'telefono-modal').attr('name', 'telefono-modal').addClass('input-modal form-control'));

    row3.append(col5);
    row3.append(col6);

    row4.append(btnModificar);
    row4.append(btnMuestraEliminar);

    col7.append($('<label>').attr('for', 'password-modal').addClass('form-label').text('Contraseña:'));
    col7.append($('<input>').attr('type', 'password').attr('id', 'password-modal').attr('name', 'password-modal').addClass('input-modal form-control'))

    row5.append(col7);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row5);
    form.append(row4);

    container.append(form);

    return container;
}

function compruebaRol() {

    if ($(".modal-body #rol-modal").val() != 12)
        $(".modal-body #puntos-modal").attr("disabled", "true");
    else
        $(".modal-body #puntos-modal").removeAttr("disabled");
}