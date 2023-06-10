var infoPlato = '<div class="container">' +
    '<div class="row d-flex justify-content-center">' +
    '<img src="" alt="" class="img-modal">' +
    '</div>' +
    '<div id="precios" class="row mt-3">' +
    '<div class="col-md-6 d-flex flex-column gap-2">' +
    '<label for="precio-entero" class="form-label text-center">Precio Ración Entera:</label>' +
    '<span class="text-center" id="precio-entera"></span>' +
    '</div>' +
    '</div>' +
    '<div class="row mt-4 d-flex flex-column">' +
    '<label for="alergenos" class="form-label">Alérgenos:</label>' +
    '<div class="container row-cols-5" id="alergenos"></div>' +
    '</div>' +
    '</div>';

$(function() {

    $(".menu-item").on("click", function() {

        let plato = $(this).find("h4").text();
        let img = $(this).find("img").attr("src");
        let precioEntera = $(this).attr("data-precio-entera");
        let precioMedia = $(this).attr("data-precio-media");
        let alergenos = $(this).attr("data-alergenos").split("|");

        let precioMediaHTML = '<div class="col-md-6 d-flex flex-column justify-content-center gap-2">' +
        '<label for="precio-mitad" class="form-label text-center">Precio Media Ración:</label>' +
        '<span class="text-center" id="precio-media"></span>' +
        '</div>'

        $(".modal-title").text(plato);

        $(".modal-body").html(infoPlato);

        $(".modal-body .img-modal").attr("src", img);
        $("#precio-entera").text(precioEntera + "€");
        
        if (precioMedia !== undefined) {
            $("#precios").append(precioMediaHTML);
            $("#precio-media").text(precioMedia + "€");
        }
        else {
            $("#precios").children(":first").removeClass("col-md-6").addClass("col-md-12");
        }

        for(let foto of alergenos) {
            let img = $("<img>");
            img.attr("src", "../assets/img/alergenos/" + foto);
            $("#alergenos").append(img);
        }

        abrirModal();
    })
})