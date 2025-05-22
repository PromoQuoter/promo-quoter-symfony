// JavaScript Document
if (typeof($) == 'undefined') {
    const $ = jQuery.noConflict();
}

/*************************** Owl Carousel ****************************/
$(document).ready(function () {
    $("#client-carousel").owlCarousel({
        autoplay: false,
        items: 3,
        loop: true,
        navText: false,
        dots: true,
        nav: false,
        mouseDrag: true,
        lazyLoad: false,
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
    });
    

});

/*--------------------------
   Fixed nav
---------------------------- */
const isMobile = {
    Android: () => !!navigator.userAgent.match(/Android/i),
    BlackBerry: () => !!navigator.userAgent.match(/BlackBerry/i),
    iOS: () => !!navigator.userAgent.match(/iPhone|iPad|iPod/i),
    Windows: () => !!navigator.userAgent.match(/IEMobile/i),
    any: () => (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows())
};

$(function () {
    if (isMobile.any()) return;

    jQuery(window).bind('scroll', function () {
        const navHeight = 200 - 70;
        if (jQuery(window).scrollTop() > navHeight) {
            jQuery('.menu_sec').addClass('fixed');
        } else {
            jQuery('.menu_sec').removeClass('fixed');
        }
    });
});