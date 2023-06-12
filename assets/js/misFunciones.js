var spinner = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

/**
 * Añadir funcionalidad select2 a los select con clase "select-2"
 */

$(".select-2").select2();

// ==============

$(function () {

  $(".modal [aria-label=Close]").on("click", cerrarModal);
})

/**
 * Función para abrir modal
 */

function abrirModal() {

  $(".modal").addClass("fade");
  setTimeout(function () {
    $(".modal").addClass("show");
  }, 25);

  $(".modal").show();
}

/** 
 * Función para cerrar modal
 */

function cerrarModal() {

    $(".modal").removeClass("fade");
    $(".modal").removeClass("show");

    $(".modal").removeAttr("data-id");

    $(".modal").hide();
}

/**
 * Función abrirToast
 */

function abrirToast(strong, body) {

  $(".toast-header strong").text(strong);
  $(".toast-body").text(body);

  $("#liveToast").toast('show');
}