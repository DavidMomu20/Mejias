/**
 * Añadir funcionalidad select2 a los select con clase "select-2"
 */

$(".select-2").select2();

// ==============

$(function() {

    /**
     * Función para cerrar el modal
     */

    $(".modal [aria-label=Close]").on("click", function() {
    
        $(".modal").removeClass("fade");
        $(".modal").removeClass("show");
      
        $(".modal").removeAttr("data-id");

        $(".modal").hide();
      })
})

/**
 * Función para abrir modal
 */

function abrirModal() {

  $(".modal").addClass("fade");
    setTimeout(function() {
        $(".modal").addClass("show");
    }, 25);

  $(".modal").show();
}