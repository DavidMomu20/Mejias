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