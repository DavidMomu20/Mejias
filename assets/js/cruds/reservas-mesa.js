$(function () {

    $(".modal .modal-title").text("Datos Reserva Mesa");

    $("#btn-modificar").attr("disabled", "true");

    $("#tabla-reservas-mesa").on("click", "tbody tr", function () {

        let form = formReservaMesa();
        $(".modal-body").html(form);

        abrirModal();

        // Mostrar datos reserva en los inputs del formulario del modal
        $("#m-id-reserva-mesa").val($(this).children("td").eq(0).text());
        $("#m-mesa").val($(this).children("td").eq(1).text());
        $("#m-estado").val($(this).children("td").eq(2).text());
        $("#m-email").val($(this).children("td").eq(3).text());
        $("#m-telefono").val($(this).children("td").eq(4).text());
        $("#m-fecha").val($(this).children("td").eq(5).attr("data-fecha"));
        $("#m-hora").val($(this).children("td").eq(6).text());
        $("#m-comensales").val($(this).children("td").eq(7).text());
    })

    $(".modal-form").change(function () {

        $("#btn-modificar").removeAttr("disabled");
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
    let col3_1 = $('<div>').addClass('col-md-6');
    let col3_2 = $('<div>').addClass('col-md-6');
    let row4 = $('<div>').addClass('row mt-2');
    let col4_1 = $('<div>').addClass('col-md-6');
    let col4_2 = $('<div>').addClass('col-md-6');
    let row5 = $('<div>').addClass('row mt-2');
    let col5_1 = $('<div>').addClass('col-md-6');
    let col5_2 = $('<div>').addClass('col-md-6');
    let row6 = $('<div>').addClass('row mt-2');
    let col6 = $('<div>').addClass('col-sm-12');
    let row7 = $('<div>').addClass('row mt-4 d-flex justify-content-center gap-3');
    let btnModificar = $('<button>').addClass('btn btn-primary col-md-4').attr('id', 'btn-modificar').text('Modificar');
    let btnEliminar = $('<button>').addClass('btn btn-danger col-md-4').attr('id', 'btn-eliminar').text('Eliminar');

    col1.append($('<label>').attr('for', 'm-id-reserva-mesa').addClass('form-label').text('ID Reserva Mesa'));
    col1.append($('<input>').attr('type', 'number').attr('name', 'm-id-reserva-mesa').attr('id', 'm-id-reserva-mesa').addClass('form-control modal-form'));

    row1.append(col1);

    col2_1.append($('<label>').attr('for', 'm-mesa').addClass('form-label').text('Mesa Asignada'));
    col2_1.append($('<input>').attr('type', 'text').attr('name', 'm-mesa').attr('id', 'm-mesa').addClass('form-control modal-form'));
    col2_2.append($('<label>').attr('for', 'm-estado').addClass('form-label').text('Estado'));
    col2_2.append($('<input>').attr('type', 'text').attr('name', 'm-estado').attr('id', 'm-estado').addClass('form-control modal-form'));

    row2.append(col2_1);
    row2.append(col2_2);

    col3_1.append($('<label>').attr('for', 'm-email').addClass('form-label').text('Email Usuario'));
    col3_1.append($('<input>').attr('type', 'email').attr('name', 'm-email').attr('id', 'm-email').addClass('form-control modal-form'));
    col3_2.append($('<label>').attr('for', 'm-telefono').addClass('form-label').text('Nº Teléfono'));
    col3_2.append($('<input>').attr('type', 'phone').attr('name', 'm-telefono').attr('id', 'm-telefono').addClass('form-control modal-form'));

    row3.append(col3_1);
    row3.append(col3_2);

    col4_1.append($('<label>').attr('for', 'm-fecha').addClass('form-label').text('Fecha'));
    col4_1.append($('<input>').attr('type', 'date').attr('name', 'm-fecha').attr('id', 'm-fecha').addClass('form-control modal-form'));
    col4_2.append($('<label>').attr('for', 'm-hora').addClass('form-label').text('Hora'));
    col4_2.append($('<input>').attr('type', 'time').attr('name', 'm-hora').attr('id', 'm-hora').addClass('form-control modal-form'));

    row4.append(col4_1);
    row4.append(col4_2);

    col5_1.append($('<label>').attr('for', 'm-comensales').addClass('form-label').text('Nº Comensales'));
    col5_1.append($('<input>').attr('type', 'number').attr('name', 'm-comensales').attr('id', 'm-comensales').addClass('form-control modal-form'));

    row5.append(col5_1);

    col6.append($('<label>').attr('for', 'm-observaciones').addClass('form-label').text('Observaciones'));
    col6.append($('<textarea>').attr('name', 'm-observaciones').attr('id', 'm-observaciones').addClass('form-control modal-form'));

    row6.append(col6);

    row7.append(btnModificar);
    row7.append(btnEliminar);

    form.append(row1);
    form.append(row2);
    form.append(row3);
    form.append(row4);
    form.append(row5);
    form.append(row6);
    form.append(row7);

    container.append(form);

    return container;
}