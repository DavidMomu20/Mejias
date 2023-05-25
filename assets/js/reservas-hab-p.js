$(function() {
    // Manejar el clic en el enlace de "Siguiente"
    $('a[data-slide="next"]').click(function() {
      $('.carousel').carousel('next');
      return false; // Evitar el comportamiento predeterminado del enlace
    });
  
    // Manejar el clic en el enlace de "Anterior"
    $('a[data-slide="prev"]').click(function() {
      $('.carousel').carousel('prev');
      return false; // Evitar el comportamiento predeterminado del enlace
    });
  });