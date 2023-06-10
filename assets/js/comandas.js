var divPlatos = $('<div>', {'class': 'row mt-2 row-cols-2 row-gap-4'});

var loading = $('<div>', {'class': 'loading'})
                .append($('<div>', {'class': 'spinner'}))
                .append($('<span>', {'class': 'cargando', text: 'Cargando platos...'}));

var bCrear = $('<div>', {'class': 'container mt-4 mb-4 text-center'})
                .append($('<button>', {'id': 'b-crear-comanda', 'class': 'btn btn-success', text: 'Crear Comanda'}));

var comanda;

$(function() {
    
    buscaPlatos(1);

    /**
     * Ver y modificar el número de platos que se ha pedido
     */

    $("#b-info-pedido").click(function() {

        $(".modal-title").text("Este es el pedido actual");
        $(".modal-body").html(comanda);
        abrirModal();
    })

    /**
     * Quitar una unidad de plato de lo ya pedido
     */

    $(".modal-body").on("click", "#b-quitar-uno", function() {

        let plato = $(this).closest(".plato-selected");
        let unidades = plato.find(".unidades span").text().replace(/[^0-9]/g, '');
        unidades -= 1;
        
        if (unidades === 0)
            plato.remove();
        else
            plato.find(".unidades span").text("x" + unidades);

        comanda = $(".modal-body").html();
    })

    /**
     * Cambiar de categoría de platos
     */

    $(".cat-comandas a").click(function() {

        let id = $(this).attr("data-id");
        buscaPlatos(id);
    })

    /**
     * Añadir plato (sea media o entera) al modal
     */

    $(".cont-platos").on("click", ".plato #b-entera", function() {
        addPedido($(this).closest(".plato"), $(this).attr("data-racion"), $(this).attr("data-value"));
    });
    $(".cont-platos").on("click", ".plato #b-media", function() {
        addPedido($(this).closest(".plato"), $(this).attr("data-racion"), $(this).attr("data-value"));
    });

    /**
     * Confirmar la comanda
     */

    $(".cont-platos").on("click", "#b-crear-comanda", function() {

        $(".modal-body").html(loading);
        abrirModal();

        $.ajax({
            url: "./dameMesasHoy", 
            type: "GET", 
            dataType: "json", 
            success: function(response) {

                if (response.mesas.length !== 0) {

                    let mesas = '<label for="mesasDisponibles">¿A cuál mesa de hoy enviamos la comanda?:</label>' +
                            '<div class="mesasDisponibles">';
    
                    for (let mesa of response.mesas)
                        mesas += '<button class="bMesa">' + mesa.id_mesa + '</button>';
    
                    mesas += '</div>' +
                            '<div class="btn-modal text-center">' +
                            "<button disabled type='button' class='btn btn-success confirmar'>\nConfirmar\n</button>" +
                            '</div>';
    
                    $(".modal-body").html(mesas);
                }
                else 
                $(".modal-body").html('<div class="text-center"><b style="color: red;"><i>¡A día de hoy no hay mesas disponibles!</i></b></div>')
            }
        })
    })

});

/**
 * Función para buscar los platos en base a la categoría pulsada
 */

function buscaPlatos(idCategoria) {

    $(".cont-platos").html(loading);
    $(".cat-comandas a").attr("disabled", "true");

    $.ajax({
        url: './damePlatos', 
        type: "POST", 
        dataType: "json", 
        data: {
            id: idCategoria
        }, 
        success: function(response) {

            divPlatos.children().remove();
            $(".cont-platos").html(divPlatos);

            for (let plato of response.platos) {

                let platoHTML = '<div id="' + plato.id_plato + '" class="plato col d-flex justify-content-center align-items-center">' +
                    '<div class="col text-center imagen">' +
                    '<img src="../assets/img/platos/' + plato.imagen + '" alt="Plato Imagen">' +
                    '</div>' +
                    '<div class="col text-center nombre">' +
                    '<h5>' + plato.nombre + '</h5>' +
                    '</div>' +
                    '<div class="col text-center div-entera">' +
                    '<button id="b-entera" class="btn btn-info" data-racion="Entera" data-value="' + plato.precio_entera + '">' +
                    '+1 Entera' +
                    '</button>' +
                    '</div>' +
                    '<div class="col text-center div-media">' +
                    '<button id="b-media" class="btn btn-info" data-racion="Media" data-value="5">' +
                    '+1 Media' +
                    '</button>' +
                    '</div>' +
                    '</div>';

                $(".cont-platos .row").append(platoHTML);
            }

            $(".cont-platos").append(bCrear);
            $(".cat-comandas a").removeAttr("disabled");
        }
    })
}

/**
 * Función para añadir un pedido a la comanda
 */

function addPedido(plato, racion, precio) {

    let id = plato.attr("id");

    let existingPlato = $(".modal-body").find(`div[data-id="${id}"][data-racion="${racion}"]`);

    if (existingPlato.length > 0) {
        
        let unidades = parseInt(existingPlato.find(".unidades span").text().replace(/[^0-9]/g, ''));
        existingPlato.find(".unidades span").text("x" + (unidades + 1))
    }

    else {

        let img = plato.find(".imagen img").attr("src");
        let nombre = plato.find(".nombre h5").text();

        let platoHTML = '<div data-id="' + id + '" data-racion="' + racion + '" data-value="' + precio + '" class="plato-selected row d-flex justify-content-center align-items-center gap-3 py-2">' +
        '<div class="col imagen">' +
        '<img src="' + img + '" alt="">' +
        '</div>' +
        '<div class="col text-center nombre">' +
        '<h5>' + nombre + '</h5>' +
        '</div>' +
        '<div class="col text-center racion">' +
        '<span>' + racion + '</span>' +
        '</div>' +
        '<div class="col text-center unidades">' +
        '<span>x1</span>' +
        '</div>' +
        '<div class="col text-center">' +
        '<button class="btn btn-danger" id="b-quitar-uno">' +
        '<i class="fa-solid fa-minus"></i>' +
        '</button>' +
        '</div>' +
        '</div>';

        $(".modal-body").append(platoHTML);
        comanda = $(".modal-body").html();

        abrirToast("Plato añadido", "Mira en el botón de info para más detalles de la comanda");
    }
}