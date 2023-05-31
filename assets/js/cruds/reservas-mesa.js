var formReservaMesa = '<div class="container">' +
    '    <form>' +
    '        <div class="row">' +
    '            <div class="col-sm-12">' +
    '                <label for="m-id-reserva-mesa" class="form-label">ID Reserva Mesa</label>' +
    '                <input type="number" name="m-id-reserva-mesa" id="m-id-reserva-mesa" class="form-control modal-form">' +
    '            </div>' +
    '        </div>' +
    '        <div class="row mt-2">' +
    '            <div class="col-md-6">' +
    '                <label for="m-mesa" class="form-label">Mesa Asignada</label>' +
    '                <input type="text" name="m-mesa" id="m-mesa" class="form-control modal-form">' +
    '            </div>' +
    '            <div class="col-md-6">' +
    '                <label for="m-estado" class="form-label">Estado</label>' +
    '                <input type="text" name="m-estado" id="m-estado" class="form-control modal-form">' +
    '            </div>' +
    '        </div>' +
    '        <div class="row mt-2">' +
    '            <div class="col-md-6">' +
    '                <label for="m-email" class="form-label">Email Usuario</label>' +
    '                <input type="email" name="m-email" id="m-email" class="form-control modal-form">' +
    '            </div>' +
    '            <div class="col-md-6">' +
    '                <label for="m-telefono" class="form-label">Nº Teléfono</label>' +
    '                <input type="phone" name="m-telefono" id="m-telefono" class="form-control modal-form">' +
    '            </div>' +
    '        </div>' +
    '        <div class="row mt-2">' +
    '            <div class="col-md-6">' +
    '                <label for="m-fecha" class="form-label">Fecha</label>' +
    '                <input type="date" name="m-fecha" id="m-fecha" class="form-control modal-form">' +
    '            </div>' +
    '            <div class="col-md-6">' +
    '                <label for="m-hora" class="form-label">Hora</label>' +
    '                <input type="time" name="m-hora" id="m-hora" class="form-control modal-form">' +
    '            </div>' +
    '        </div>' +
    '        <div class="row mt-2">' +
    '            <div class="col-sm-12">' +
    '                <label for="m-comensales" class="form-label">Nº Comensales</label>' +
    '                <input type="number" name="m-comensales" id="m-comensales" class="form-control modal-form">' +
    '            </div>' +
    '        </div>' +
    '        <div class="row mt-4 d-flex justify-content-center gap-3">' +
    '            <button id="btn-modificar" class="btn btn-primary col-md-4">' +
    '                Modificar' +
    '            </button>' +
    '            <button id="btn-eliminar" class="btn btn-danger col-md-4">' +
    '                Eliminar' +
    '            </button>' +
    '        </div>' +
    '    </form>' +
    '</div>';


$(function () {

    $(".modal .modal-title").text("Datos Reserva Mesa");
    $(".modal-body").empty();
    $(".modal-body").html(formReservaMesa);

    $("#btn-modificar").attr("disabled", "true");

    $("#tabla-reservas-mesa").on("click", "tbody tr", function () {

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

    $(".modal-form").change(function() {

        $("#btn-modificar").removeAttr("disabled");
    })
})