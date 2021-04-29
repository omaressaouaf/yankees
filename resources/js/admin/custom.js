(function() {
    $("html").removeClass("perfect-scrollbar-on");

    $("html").addClass("perfect-scrollbar-off");

    $('#minimizeSidebar').click(function() {
        $('body').toggleClass('sidebar-mini');
    });
	// Preloader
	$(window).on('load', function() {
        if ($('#preloader').length) {
          $('#preloader').delay(100).fadeOut('slow', function() {
            $(this).remove();
          });
        }
      });
})();
