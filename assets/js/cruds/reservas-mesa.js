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
        $(".modal-body").html(form);

        abrirModal();

    })

})

function formReservaMesa() {
    let container = $('<div>').addClass('container');
    let form = $('<form>');
    let row1 = $('<div>').addClass('row');
    let col1 = $('<div>').addClass('col-sm-12');
    let row2 = $('<div>').addClass('row mt-2');
    let col2_1 = $('<div>').addClass('col-md-6');
    let col2_2 = $('<div>').addClass('col-md-6');
    let row3 = $('<div>').addClass('row mt-2');
    let col3_1 = $('<div>').addClass('col-md-12');
    let row4 = $('<div>').addClass('row mt-2');
    let col4_1 = $('<div>').addClass('col-md-6');
    let col4_2 = $('<div>').addClass('col-md-6');
    let row5 = $('<div>').addClass('row mt-2');
    let col5_1 = $('<div>').addClass('col-md-12');
    let row7 = $('<div>').addClass('row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').text('Modificar');
    let btnMuestraEliminar = $('<button>').attr("type", "button").addClass('btn btn-danger col-md-4').attr('id', 'btn-muestra-eliminar').text('\nEliminar');

    col1.append($('<label>').attr('for', 'm-id-reserva-mesa').addClass('form-label').text('ID Reserva Mesa'));
    col1.append($('<input>').attr('type', 'number').attr('name', 'm-id-reserva-mesa').attr('id', 'm-id-reserva-mesa').addClass('form-control input-modal modal-form'));

    row1.append(col1);

    col2_1.append($('<label>').attr('for', 'm-mesa').addClass('form-label').text('Mesa Asignada'));
    col2_1.append($('<select>').attr('type', 'text').attr('name', 'm-mesa').attr('id', 'm-mesa').addClass('form-control input-modal modal-form'));
    col2_2.append($('<label>').attr('for', 'm-estado').addClass('form-label').text('Estado'));
    col2_2.append($('<select>').attr('type', 'text').attr('name', 'm-estado').attr('id', 'm-estado').addClass('form-control input-modal modal-form'));

    row2.append(col2_1);
    row2.append(col2_2);

    col3_1.append($('<label>').attr('for', 'm-email').addClass('form-label').text('Email Usuario'));
    col3_1.append($('<input>').attr('type', 'email').attr('name', 'm-email').attr('id', 'm-email').addClass('form-control input-modal modal-form'));

    row3.append(col3_1);

    col4_1.append($('<label>').attr('for', 'm-fecha').addClass('form-label').text('Fecha'));
    col4_1.append($('<input>').attr('type', 'date').attr('name', 'm-fecha').attr('id', 'm-fecha').addClass('form-control input-modal modal-form'));
    col4_2.append($('<label>').attr('for', 'm-hora').addClass('form-label').text('Hora'));
    col4_2.append($('<input>').attr('type', 'time').attr('name', 'm-hora').attr('id', 'm-hora').addClass('form-control input-modal modal-form'));

    row4.append(col4_1);
    row4.append(col4_2);

    col5_1.append($('<label>').attr('for', 'm-comensales').addClass('form-label').text('Nº Comensales'));
    col5_1.append($('<input>').attr('type', 'number').attr('name', 'm-comensales').attr('id', 'm-comensales').addClass('form-control input-modal modal-form'));

    row5.append(col5_1);

    row7.append(btnModificar);
    row7.append(btnMuestraEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row4);
    form.append(row5);
    form.append(row7);

    container.append(form);

    return container;
}