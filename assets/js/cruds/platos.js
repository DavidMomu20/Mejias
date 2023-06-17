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

    $("#tabla-platos").on("click", "tbody tr", function() {

        id = parseInt($(this).attr("data-index"));

        let form = formPlato();
        $(".modal-title").text("Datos Plato");
        $(".modal-body").html(form);

        abrirModal();
    })
})

/**
 * Función para crear formulario de modal
 */

function formPlato() {

    let container = $('<div>').addClass('container plato-modal');
    let form = $('<form>');

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

    col1_1.append($('<img>').attr('src', '../../img/platos/'));
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