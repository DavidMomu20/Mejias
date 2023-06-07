const valPunto = 0.05;
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

    let id = $(this).closest(".reserva-hab").attr("data-index");
    let precio = $(this).closest(".reserva-hab").attr("data-precio");
    let puntos = parseInt($(this).closest(".reserva-hab").attr("data-puntos"));

    let fecha_inicio = new Date($(this).closest(".reserva-hab").find(".reserva-fecha-inicio").attr("data-value"));
    let fecha_fin = new Date($(this).closest(".reserva-hab").find(".reserva-fecha-fin").attr("data-value"));

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

      let spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

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
          total: total 
        },
        success: function(response) {

          console.log("Correo enviado con éxito");
        }
      })
    })
  })
});