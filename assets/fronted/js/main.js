// any CSS you import will output into a single css file (app.css in this case)
import '../css/style.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
require('bootstrap');
require('owl.carousel');
require('scrollreveal');
require('jquery-ui');
require('@fortawesome/fontawesome-free/js/all.min');

'use strict';

(function ($) {

    /*------------------
    Preloader
    --------------------*/
    $(window).on('load', function () {
        $(".loader").fadeOut();
        $("#preloder").delay(200).fadeOut("slow");
    });

    /*------------------
        Background Set
    --------------------*/
    $('.set-bg').each(function () {
        var bg = $(this).data('setbg');
        $(this).css('background-image', 'url(' + bg + ')');
    });

    $(".canvas-open").on('click', function () {
        $(".offcanvas-menu-wrapper").addClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").addClass("active");
    });

    $(".canvas-close, .offcanvas-menu-overlay").on('click', function () {
        $(".offcanvas-menu-wrapper").removeClass("show-offcanvas-menu-wrapper");
        $(".offcanvas-menu-overlay").removeClass("active");
    });

    /*------------------
    Menu Hover
    --------------------*/
    $(".header-section .top-nav .main-menu ul li").on('mousehover', function () {
        $(this).addClass('active');
    });
    $(".header-section .top-nav .main-menu ul li").on('mouseleave', function () {
        $('.header-section .top-nav .main-menu ul li').removeClass('active');
    });

    /*------------------
    Carousel Slider
    --------------------*/
    var hero_s = $(".hero-items");
    var thumbnailSlider = $(".thumbs");
    var duration = 500;
    var syncedSecondary = true;

    setTimeout(function () {
        $(".cloned .item-slider-model a").attr("data-fancybox", "group-2");
    }, 500);

    // carousel function for main slider
    hero_s.owlCarousel({
        loop: true,
        nav: false,
        navText: ['<i class="arrow_carrot-left"></i>', '<i class="arrow_carrot-right"></i>'],
        items: 1,
        dots: false,
        autoplay: true,
        animateOut: 'fadeOut',
        smartSpeed: 1200,
        autoHeight: false,
    }).on("changed.owl.carousel");

})(jQuery);