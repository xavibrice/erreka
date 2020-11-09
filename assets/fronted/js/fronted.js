/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/fronted.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';

require('bootstrap');
require('owl.carousel');
require('scrollreveal');
require('@fortawesome/fontawesome-free/js/all.min');

// Preloader
$(window).on('load', function() {
    if ($('#preloader').length) {
        $('#preloader').delay(100).fadeOut('slow', function() {
            $(this).remove();
        });
    }
});

/*--/ Carousel owl /--*/
$('#carousel').owlCarousel({
    loop: true,
    margin: -1,
    items: 1,
    nav: true,
    navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
    autoplay: true,
    autoplayTimeout: 3000,
    autoHeight: false,
    autoPlay: false,
    // autoplayHoverPause: true
});

/*--/ Animate Carousel /--*/
$('.intro-carousel').on('translate.owl.carousel', function() {
    $('.intro-content .intro-title').removeClass('animate__zoomIn animate__animated').hide();
    $('.intro-content .intro-price').removeClass('animate__fadeInUp animate__animated').hide();
    $('.intro-content .intro-title-top, .intro-content .spacial').removeClass('animate__fadeIn animate__animated').hide();
});

$('.intro-carousel').on('translated.owl.carousel', function() {
    $('.intro-content .intro-title').addClass('animate__zoomIn animate__animated').show();
    $('.intro-content .intro-price').addClass('animate__fadeInUp animate__animated').show();
    $('.intro-content .intro-title-top, .intro-content .spacial').addClass('animate__fadeIn animate__animated').show();
});

/*--/ Navbar Collapse /--*/
$('.navbar-toggle-box-collapse').on('click', function() {
    $('body').removeClass('box-collapse-closed').addClass('box-collapse-open');
});
$('.close-box-collapse, .click-closed').on('click', function() {
    $('body').removeClass('box-collapse-open').addClass('box-collapse-closed');
    $('.menu-list ul').slideUp(700);
});

/*--/ Navbar Menu Reduce /--*/
$(window).trigger('scroll');
$(window).bind('scroll', function() {
    var pixels = 50;
    var top = 1200;
    if ($(window).scrollTop() > pixels) {
        $('.navbar-default').addClass('navbar-reduce');
        $('.navbar-default').removeClass('navbar-trans');
    } else {
        $('.navbar-default').addClass('navbar-trans');
        $('.navbar-default').removeClass('navbar-reduce');
    }
    if ($(window).scrollTop() > top) {
        $('.scrolltop-mf').fadeIn(1000, "easeInOutExpo");
    } else {
        $('.scrolltop-mf').fadeOut(1000, "easeInOutExpo");
    }
});

/*--/ Property owl /--*/
$('#property-carousel').owlCarousel({
    loop: true,
    margin: 30,
    responsive: {
        0: {
            items: 1,
        },
        769: {
            items: 2,
        },
        992: {
            items: 3,
        }
    }
});

/*--/ Property owl owl /--*/
$('#property-single-carousel').owlCarousel({
    loop: true,
    margin: 0,
    nav: true,
    autoHeight:true,
    navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
    responsive: {
        0: {
            items: 1,
        }
    }
});

/*--/ News owl /--*/
$('#new-carousel').owlCarousel({
    loop: true,
    margin: 30,
    responsive: {
        0: {
            items: 1,
        },
        769: {
            items: 2,
        },
        992: {
            items: 3,
        }
    }
});

/*--/ Testimonials owl /--*/
$('#testimonial-carousel').owlCarousel({
    margin: 0,
    autoplay: true,
    nav: true,
    animateOut: 'fadeOut',
    animateIn: 'fadeInUp',
    navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right" aria-hidden="true"></i>'],
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    responsive: {
        0: {
            items: 1,
        }
    }
});

/*------------------
    Background Set
--------------------*/
$('.set-bg').each(function () {
    var bg = $(this).data('setbg');
    $(this).css('background-image', 'url(' + bg + ')');
});

/*-------------------
    Feature Slider
--------------------- */
$(".feature-carousel").owlCarousel({
    items: 3,
    dots: true,
    autoplay: true,
    margin: 0,
    loop: true,
    smartSpeed: 1200,
    responsive: {
        320: {
            items: 1,
        },
        768: {
            items: 2,
        },
        992: {
            items: 3,
        }
    }
});