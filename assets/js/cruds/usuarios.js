var id = 0;

$(function () {

    /**
     * Cuando se pulsa un registro, se abrirá un modal con todos sus datos, 
     * además de los botones modificar y eliminar.
     */

    $("#tabla-usuarios").on("click", "tbody tr", function () {

        id = parseInt($(this).attr("data-id"));

        let form = formUsuario();
        $(".modal-body").html(form);

        $("#nombre-modal").val($(this).children("td").eq(0).text());
        $("#apellido-modal").val($(this).children("td").eq(1).text());
        $("#rol-modal").val($(this).children("td").eq(2).attr("data-value"));
        $("#puntos-modal").val($(this).children("td").eq(5).text());
        $("#correo-modal").val($(this).children("td").eq(3).text());
        $("#telefono-modal").val($(this).children("td").eq(4).text());

        abrirModal();

        $(".input-modal").change(function() {

            $("#btn-modificar").removeAttr("disabled");
        })

        /**
         * Al pulsar el botón modificar, se recogerán todos los datos 
         * del modal y se modificarán los datos en la base de datos.
         */

        $("#btn-modificar").click(function() {

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
                    puntos: $("#puntos-modal").val()
                }, 
                success: function(response) {

                    abrirToast(response.data, "Puedes ver las modificaciones aplicadas en la tabla");
                    cerrarModal();
                }
            })
        })
    })

    /**
     * Abrir modal de creacion de nuevo registro
     */

    $("#b-crud-crear").click(function() {

        let form = formUsuario();
        form.find(".botones-modal").empty();
        form.find(".botones-modal").html($(this).clone());

        $(".modal-body").html(form);
        abrirModal();
    })
})

/**
 * Función que crea el formulario de modal para usuarios
 */

function formUsuario() {
    let container = $('<div>').addClass('container');
    let form = $('<form>');
    let row1 = $('<div>').addClass('row');
    let col1 = $('<div>').addClass('col-md-6 text-center');
    let col2 = $('<div>').addClass('col-md-6 text-center');
    let row2 = $('<div>').addClass('row mt-2');
    let col3 = $('<div>').addClass('col-md-6 text-center');
    let col4 = $('<div>').addClass('col-md-6 text-center');
    let row3 = $('<div>').addClass('row mt-2');
    let col5 = $('<div>').addClass('col-md-6 text-center');
    let col6 = $('<div>').addClass('col-md-6 text-center');
    let row4 = $('<div>').addClass('botones-modal row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').attr("type", "button").attr('disabled', true).addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').text('\nModificar');
    let btnEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-eliminar').text('\nEliminar');

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
    row4.append(btnEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row4);

    container.append(form);

    return container;
}