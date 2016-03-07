(function($) {
    'use strict';



        
    /* --------------------------------*/
    /* - Doc Ready
     /* -------------------------------*/

    $(document).ready(function() {
        $('.carousel').carousel({
            interval: 5000 //changes the speed
        })
        $("section, div, figure").each(function(indx) {
            if ($(this).attr("data-background")) {
                $(this).css("background-image", "url(" + $(this).data("background") + ") ");
                $(this).css("background-repeat", "no-repeat");
                $(this).css("background-size", "100% 100%");
                
            }
        });
        // services
        var owl = $('.owl-carousel');
        owl.owlCarousel({
            loop: true,
            navigation:true,
            responsive: {
            0: {
            items: 1
            },
            600: {
            items: 2
            },
            1000: {
            items: 3
            }
            }
        })
        
});
$( window ).load(function() {
  // our work
        var $grid = $('.grid').isotope({
            // options
            itemSelector: '.element-item',
            layoutMode: 'fitRows'
        });
        // filter items on button click
        $('.filter-button-group').on( 'click', 'button', function() {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({ filter: filterValue });
        });

});
    $(window).scroll(function() {    
        var scroll = $(window).scrollTop();
        if (scroll >= 100) {
            $(".navbar").addClass("fixmenu", 2000);
        }
        else
            $(".navbar").removeClass("fixmenu", 2000);
    });
        

})(jQuery);