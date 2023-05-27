$(function() {
    $(window).resize(function() {
        
        let anchoDiv = $("#layoutSidenav_content").width();

        if (anchoDiv <= 576) {
            $('.row-cols-dynamic').removeClass('row-cols-2 row-cols-3 row-cols-4 row-cols-5').addClass('row-cols-1');
        } else if (anchoDiv <= 768) {
            $('.row-cols-dynamic').removeClass('row-cols-1 row-cols-3 row-cols-4 row-cols-5').addClass('row-cols-2');
        } else if (anchoDiv <= 992) {
            $('.row-cols-dynamic').removeClass('row-cols-1 row-cols-2 row-cols-4 row-cols-5').addClass('row-cols-3');
        } else if (anchoDiv <= 1200) {
            $('.row-cols-dynamic').removeClass('row-cols-1 row-cols-2 row-cols-3 row-cols-5').addClass('row-cols-4');
        } else {
            $('.row-cols-dynamic').removeClass('row-cols-1 row-cols-2 row-cols-3 row-cols-4').addClass('row-cols-5');
        }
    });

    $("#carta-accordion .card").click(function() {

        $(this).toggleClass('plato-selected');
    })
});