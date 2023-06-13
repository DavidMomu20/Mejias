const valPunto = 0.05;

var razones = $('<div>').addClass('cont-razones text-center')
.append(
    $('<label>').addClass('form-label').attr('for', 'razones').text('¿A qué se debe el rechazo de esta reserva?:'),
    $('<select>').addClass('form-control mt-3').attr('name', 'razones').attr('id', 'razones')
        .append(
            $('<option>').attr('value', 'sin-mesas').prop('selected', true).text('No existen mesas disponibles'),
            $('<option>').attr('value', 'mal-comportamiento').text('Comportamiento negativo previo'),
            $('<option>').attr('value', 'otro').text('Otro...')
        ),
    $('<div>').addClass('otra-razon-div mt-3 d-none')
        .append(
            $('<label>').addClass('form-label').attr('for', 'otra-razon').text('Detalle el problema, por favor:'),
            $('<textarea>').addClass('form-control').attr('name', 'otra-razon').attr('id', 'otra-razon').attr('cols', '5').attr('rows', '10').css('resize', 'none')
        ), 
    $('<div>').addClass('d-flex justify-content-center mt-3').append(
        $('<button>').attr('id', 'b-enviar-rechazo').addClass('btn btn-danger').text("\nEnviar")
    )
);

var razon = "";

var confirmarHTML = '<div class="container text-center">' +
  '    <p class="mt-2" style="font-style: italic;">Se le enviará un correo con la fianza (PDF) de la reserva. Así quedaría la cuenta:</p>' +
  '    <p class="mt-2">' +
  '        <span class="fw-bold dinero-noche"></span> /noche' +
  '        x' +
  '        <span class="fw-bold n-dias"></span> días =' +
  '        <span class="fw-bold total"></span>' +
  '    </p>' +
  '</div>';

$(function () {

  // Manejar el clic en el enlace de "Siguiente"
  $('a[data-slide="next"]').click(function () {
    $('.carousel').carousel('next');
    return false; // Evitar el comportamiento predeterminado del enlace
  });

  // Manejar el clic en el enlace de "Anterior"
  $('a[data-slide="prev"]').click(function () {
    $('.carousel').carousel('prev');
    return false; // Evitar el comportamiento predeterminado del enlace
  });

  /**
   * Confirmar reserva de habitación
   */

  $(".b-confirmar-rh").on("click", function () {

    let div = $(this).closest(".reserva-hab");

    let email = div.attr("data-email");
    let fullName = div.find(".reserva-nombre").text();

    let id = div.attr("data-index");
    let precio = div.attr("data-precio");
    let puntos = parseInt(div.attr("data-puntos"));

    let fecha_inicio = new Date(div.find(".reserva-fecha-inicio").attr("data-value"));
    let fecha_fin = new Date(div.find(".reserva-fecha-fin").attr("data-value"));

    let nDias = Math.floor((fecha_fin - fecha_inicio) / (1000 * 60 * 60 * 24));
    let total = precio * nDias;

    $(".modal-body").html(confirmarHTML);
    $(".modal-body .dinero-noche").text(precio + "€");
    $(".modal-body .n-dias").text(nDias);
    $(".modal-body .total").text(total + "€");

    if (puntos !== 0) {
      total = (total - (puntos * valPunto));
      let puntosHTML = '<p class="mt-2">Al haber usado ' + puntos + ' puntos, se le quedará en <span class="fw-bold">' + total + '€</span>.</p>';
      $(".modal-body .container").append(puntosHTML);
    }

    $(".modal-body .container").append('<button class="btn btn-success b-realizar-reserva">\nConfirmar\n</button>');

    $(".modal-title").text("Confirmar Reserva de Habitación");
    abrirModal();

    /**
     * Enviar el correo con la fianza en PDF
     */

    $(".b-realizar-reserva").on("click", function () {

      $(this).prepend(spinner);
      $(this).attr("disabled", "true");

      $.ajax({
        url: "./confirmarReservaHab",
        type: "POST",
        dataType: "json",
        data: {
          id_reserva_hab: id, 
          precio: precio, 
          puntos: puntos,
          n_dias: nDias, 
          total: total, 
          email: email, 
          full_name: fullName
        },
        success: function(response) {

          $(".modal-body").html('<div class="container text-center"><p>Correo con PDF de fianza enviado con éxito</p></div>');
          div.remove();
        }
      })
    })
  })

  $(".b-rechazar-rh").click(function() {

    let div = $(this).closest(".reserva-hab");

    let email = div.attr("data-email");
    let fullName = div.find(".reserva-usuario span").text();

    let id = div.attr("data-index");

    $(".modal .modal-title").text("Rechazar Reserva de Mesa");
    $(".modal-body").html(razones);
    abrirModal();

    $("#razones").change(function() {

        ($(this).val() == "otro")
        ? $(".otra-razon-div").removeClass("d-none")
        : $(".otra-razon-div").addClass("d-none")
    })

    $("#b-enviar-rechazo").click(function() {

      $(this).prepend(spinner);
      $(this).attr("disabled", "true");

      switch($("#razones").val()) {
          case "sin-mesas": 
              razon = "El rechazo de esta reserva se debe a que no hay mesas disponibles en este momento. Lamentamos las molestias y te invitamos a intentarlo nuevamente más tarde.";
              break;
          case "mal-comportamiento":
              razon = "El rechazo de esta reserva se debe a comportamientos negativos previos por parte del cliente. Nos tomamos muy en serio la tranquilidad y comodidad de todos nuestros clientes y, por tanto, hemos decidido no aceptar esta reserva.";
              break;
          default:
              razon = $("#otra-razon").val();
              break;
      }        

      $.ajax({
          url: "./rechazarReservaHab", 
          type: "POST", 
          dataType: "json", 
          data: {
              id_reserva_hab: id,
              razon: razon, 
              email: email, 
              full_name: fullName
          }, 
          success: function(response) {

              $(".modal-body").empty();
              $(".modal-body").html("<p>" + response.data + "</p>");

              div.remove();
          }
      })
    })
  })
});