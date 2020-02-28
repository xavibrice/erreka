/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// import  $ from 'jquery';
import moment from "moment";

require('bootstrap');
require('datatables.net');
require('moment');

// require('datatables.net-bs4');
// require('bootstrap-datepicker');

const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

const autocomplete = require('autocomplete.js');

require("eonasdan-bootstrap-datetimepicker-bootstrap4beta");

$.extend(true, $.fn.datetimepicker.defaults, {
    icons: {
        time: 'far fa-clock',
        date: 'far fa-calendar',
        up: 'fas fa-arrow-up',
        down: 'fas fa-arrow-down',
        previous: 'fas fa-chevron-left',
        next: 'fas fa-chevron-right',
        today: 'fas fa-calendar-check',
        clear: 'far fa-trash-alt',
        close: 'far fa-times-circle'
    }
});


// var date = new Date();
// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$(document).ready(function () {
    $('.js-datepicker').datetimepicker({
        format: moment().format('L'),
        locale: 'es',
    });

    $(".js-datepicker-empty").datetimepicker({
        format: moment().format('L'),
        locale: 'es',
    });
});

$(document).ready(function () {
    $('.js-client-autocomplete').each(function () {
        var autocompleteUrl = $(this).data('autocomplete-url');

        autocomplete('.js-client-autocomplete', { hint: false }, [
            {
                source: function (query, cb) {
                    $.ajax({
                        url: autocompleteUrl+'?query='+query
                    }).then(function (data) {
                        cb(data.clients);
                    })
                },
                // displayKey: function(sugg) { return sugg.full_name + ' - ' + sugg.mobile },
                displayKey: 'full_name',
                debounce: 500
            }
        ])
    });
});

$(document).ready(function () {
    $('.js-property-autocomplete').each(function () {
        var autocompleteUrl = $(this).data('autocomplete-url');

        autocomplete('.js-property-autocomplete', {hint: false}, [
            {
                source: function (query, cb) {
                    $.ajax({
                        url: autocompleteUrl+'?query='+query
                    }).then(function (data) {
                        cb(data.properties);
                        console.log(data)
                    })
                },
                displayKey: function(sugg) { return sugg.street.name + ' Nº ' + sugg.portal + ', ' + sugg.floor },

                debounce: 500
            }
        ])
    });
});

$(document).ready(function () {
    $('.js-commercial-autocomplete').each(function () {
        var autocompleteUrl = $(this).data('autocomplete-url');

        autocomplete('.js-commercial-autocomplete', {hint: false}, [
            {
                source: function (query, cb) {
                    $.ajax({
                        url: autocompleteUrl+'?query='+query
                    }).then(function (data) {
                        cb(data.commercials);
                    })
                },
                displayKey: 'full_name',
                debounce: 500
            }
        ])
    });
});

const routes = require('../../public/js/fos_js_routes');
// const Routing = require('./Components/Routing');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router';
// require('@fortawesome/fontawesome-free/js/all');

// global.$ = global.jQuery = $;

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function() {
    $('#dataTableEmpty').DataTable( {
        // "orderSequence": ["desc"],
        "lengthMenu": [ 10, 15, 25, 50, 100 ],
        "pageLength": 15,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
} );

$(document).ready(function() {
    $('#dataTable').DataTable( {
        // "orderSequence": ["desc"],
        "lengthMenu": [ 10, 15, 25, 50, 100 ],
        "pageLength": 15,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });
} );
//
// $(document).ready(function ($) {
//     $('.clickable-row').on('click', function (event) {
//         window.location = $(this).data("href");
//         console.log($(this).data("href"))
//     });
// });

$(document).ready(function() {
    // var table = $('#dataTable').DataTable();

    $('#dataTable tbody').on('click', 'tr', function () {
        // var data = table.row( this ).data();
        window.location = $(this).data("href");

        // alert( 'You clicked on '+data[0]+'\'s row' );
    } );
} );

$('.custom-file-input').on('change', function (event) {
    var inputFile = event.currentTarget;
    $(inputFile).parent()
        .find('.custom-file-label')
        .html(inputFile.files[0].name);
});

/*$("#appbundle_news_zone").change(function () {
    const data = {
        zone_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin2/news/zone_street',
        data: data,
        success: function (data) {
            if (data.length > 0) {
                const $street_selector = $('#appbundle_news_streets');
                $street_selector.html('<option> Selecciona Calle </option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $street_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
                console.log(data);
            } else {
                const $street_selector = $('#appbundle_news_streets');
                $street_selector.html('<option> Selecciona primero una zona </option>');
            }

        },
    });
});*/

// this variable is the list in the dom, it's initiliazed when the document is ready
var $collectionHolder;
// the link which we click on to add new items
var $addNewItem = $('<a href="#" class="btn btn-info"> Añadir </a>');
// when the page is loaded and ready
$(document).ready(function () {
    // get the collectionHolder, initilize the var by getting the list;
    $collectionHolder = $('#collectionInput');
    // append the add new item link to the collectionHolder
    $collectionHolder.append($addNewItem);
    // add an index property to the collectionHolder which helps track the count of forms we have in the list
    $collectionHolder.data('index', $collectionHolder.find('.panel').length);
    // finds all the panels in the list and foreach one of them we add a remove button to it
    // add remove button to existing items
    $collectionHolder.find('.panel').each(function () {
        // $(this) means the current panel that we are at
        // which means we pass the panel to the addRemoveButton function
        // inside the function we create a footer and remove link and append them to the panel
        // more informations in the function inside
        addRemoveButton($(this));
    });
    // handle the click event for addNewItem
    $addNewItem.click(function (e) {
        // preventDefault() is your  homework if you don't know what it is
        // also look up preventPropagation both are usefull
        e.preventDefault();
        // create a new form and append it to the collectionHolder
        // and by form we mean a new panel which contains the form
        addNewForm();
    })
});

/*
 * creates a new form and appends it to the collectionHolder
 */
function addNewForm() {
    // getting the prototype
    // the prototype is the form itself, plain html
    var prototype = $collectionHolder.data('prototype');
    // get the index
    // this is the index we set when the document was ready, look above for more info
    var index = $collectionHolder.data('index');
    // create the form
    var newForm = prototype;
    // replace the __name__ string in the html using a regular expression with the index value
    newForm = newForm.replace(/__name__/g, index);
    // incrementing the index data and setting it again to the collectionHolder
    $collectionHolder.data('index', index+1);
    // create the panel
    // this is the panel that will be appending to the collectionHolder
    var $panel = $('<div class="panel panel-warning"><div class="panel-heading"></div></div>');
    // create the panel-body and append the form to it
    var $panelBody = $('<div class="panel-body"></div>').append(newForm);
    // append the body to the panel
    $panel.append($panelBody);
    // append the removebutton to the new panel
    addRemoveButton($panel);
    // append the panel to the addNewItem
    // we are doing it this way to that the link is always at the bottom of the collectionHolder
    $addNewItem.before($panel);
}

/**
 * adds a remove button to the panel that is passed in the parameter
 * @param $panel
 */
function addRemoveButton ($panel) {
    // create remove button
    var $removeButton = $('<a href="#" class="btn btn-danger">Eliminar</a>');
    // appending the removebutton to the panel footer
    var $panelFooter = $('<div class="panel-footer"></div>').append($removeButton);
    // handle the click event of the remove button
    $removeButton.click(function (e) {
        e.preventDefault();
        // gets the parent of the button that we clicked on "the panel" and animates it
        // after the animation is done the element (the panel) is removed from the html
        $(e.target).parents('.panel').slideUp(1000, function () {
            $(this).remove();
        })
    });
    // append the footer to the panel
    $panel.append($panelFooter);
}

// (function($){
//     $.fn.datepicker.dates['es'] = {
//         days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
//         daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
//         daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
//         months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
//         monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
//         today: "Hoy",
//         monthsTitle: "Meses",
//         clear: "Borrar",
//         weekStart: 1,
//         format: "dd/mm/yyyy"
//     };
// }(jQuery));


// var date = new Date();
// var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
// $(document).ready(function() {
//     // you may need to change this code if you are not using Bootstrap Datepicker
//     $('.js-datepicker').datepicker({
//         language: 'es',
//         format: 'dd-mm-yyyy',
//         todayHighlight: true,
//         autoclose: true,
//     });
//     $('.js-datepicker').datepicker('setDate', today);
// });
//
// $(document).ready(function() {
//     // you may need to change this code if you are not using Bootstrap Datepicker
//     $('.js-datepicker-empty').datepicker({
//         language: 'es',
//         format: 'dd-mm-yyyy',
//         todayHighlight: true,
//         autoclose: true,
//     });
// });

$("#property_situation").change(function () {
    const data = {
        situation_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin/situation/situation_reason',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#property_reason');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#property_reason');
                $reason_selector.html('<option> Selecciona primero una situación</option>');
            }
        }
    });

});

$("#property_to_developer_situation").change(function () {
    const data = {
        situation_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin/situation/situation_reason',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#property_to_developer_reason');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#property_to_developer_reason');
                $reason_selector.html('<option> Selecciona primero una situación</option>');
            }
        }
    });

});

$("#property_to_developer_zone").change(function () {
    const data = {
        zone_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin/zone/zone_street',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#property_to_developer_street');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#property_to_developer_street');
                $reason_selector.html('<option> Selecciona primero una zona</option>');
            }
        }
    });

});

$("#property_zone").change(function () {
    const data = {
        zone_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin/zone/zone_street',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#property_street');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#property_street');
                $reason_selector.html('<option> Selecciona primero una zona</option>');
            }
        }
    });

});


$("#local_zone").change(function () {
    const data = {
        zone_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin/zone/zone_street',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#local_street');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#local_street');
                $reason_selector.html('<option> Selecciona primero una zona</option>');
            }
        }
    });

});

(function(factory){if(typeof define==="function"&&define.amd){define(["jquery"],function($){return factory($)})}else if(typeof module==="object"&&typeof module.exports==="object"){exports=factory(require("jquery"))}else{factory(jQuery)}})(function($){$.easing.jswing=$.easing.swing;var pow=Math.pow,sqrt=Math.sqrt,sin=Math.sin,cos=Math.cos,PI=Math.PI,c1=1.70158,c2=c1*1.525,c3=c1+1,c4=2*PI/3,c5=2*PI/4.5;function bounceOut(x){var n1=7.5625,d1=2.75;if(x<1/d1){return n1*x*x}else if(x<2/d1){return n1*(x-=1.5/d1)*x+.75}else if(x<2.5/d1){return n1*(x-=2.25/d1)*x+.9375}else{return n1*(x-=2.625/d1)*x+.984375}}$.extend($.easing,{def:"easeOutQuad",swing:function(x){return $.easing[$.easing.def](x)},easeInQuad:function(x){return x*x},easeOutQuad:function(x){return 1-(1-x)*(1-x)},easeInOutQuad:function(x){return x<.5?2*x*x:1-pow(-2*x+2,2)/2},easeInCubic:function(x){return x*x*x},easeOutCubic:function(x){return 1-pow(1-x,3)},easeInOutCubic:function(x){return x<.5?4*x*x*x:1-pow(-2*x+2,3)/2},easeInQuart:function(x){return x*x*x*x},easeOutQuart:function(x){return 1-pow(1-x,4)},easeInOutQuart:function(x){return x<.5?8*x*x*x*x:1-pow(-2*x+2,4)/2},easeInQuint:function(x){return x*x*x*x*x},easeOutQuint:function(x){return 1-pow(1-x,5)},easeInOutQuint:function(x){return x<.5?16*x*x*x*x*x:1-pow(-2*x+2,5)/2},easeInSine:function(x){return 1-cos(x*PI/2)},easeOutSine:function(x){return sin(x*PI/2)},easeInOutSine:function(x){return-(cos(PI*x)-1)/2},easeInExpo:function(x){return x===0?0:pow(2,10*x-10)},easeOutExpo:function(x){return x===1?1:1-pow(2,-10*x)},easeInOutExpo:function(x){return x===0?0:x===1?1:x<.5?pow(2,20*x-10)/2:(2-pow(2,-20*x+10))/2},easeInCirc:function(x){return 1-sqrt(1-pow(x,2))},easeOutCirc:function(x){return sqrt(1-pow(x-1,2))},easeInOutCirc:function(x){return x<.5?(1-sqrt(1-pow(2*x,2)))/2:(sqrt(1-pow(-2*x+2,2))+1)/2},easeInElastic:function(x){return x===0?0:x===1?1:-pow(2,10*x-10)*sin((x*10-10.75)*c4)},easeOutElastic:function(x){return x===0?0:x===1?1:pow(2,-10*x)*sin((x*10-.75)*c4)+1},easeInOutElastic:function(x){return x===0?0:x===1?1:x<.5?-(pow(2,20*x-10)*sin((20*x-11.125)*c5))/2:pow(2,-20*x+10)*sin((20*x-11.125)*c5)/2+1},easeInBack:function(x){return c3*x*x*x-c1*x*x},easeOutBack:function(x){return 1+c3*pow(x-1,3)+c1*pow(x-1,2)},easeInOutBack:function(x){return x<.5?pow(2*x,2)*((c2+1)*2*x-c2)/2:(pow(2*x-2,2)*((c2+1)*(x*2-2)+c2)+2)/2},easeInBounce:function(x){return 1-bounceOut(1-x)},easeOutBounce:bounceOut,easeInOutBounce:function(x){return x<.5?(1-bounceOut(1-2*x))/2:(1+bounceOut(2*x-1))/2}})});

!function(t){"use strict";t("#sidebarToggle, #sidebarToggleTop").on("click",function(o){t("body").toggleClass("sidebar-toggled"),t(".sidebar").toggleClass("toggled"),t(".sidebar").hasClass("toggled")&&t(".sidebar .collapse").collapse("hide")}),t(window).resize(function(){t(window).width()<768&&t(".sidebar .collapse").collapse("hide")}),t("body.fixed-nav .sidebar").on("mousewheel DOMMouseScroll wheel",function(o){if(768<t(window).width()){var e=o.originalEvent,l=e.wheelDelta||-e.detail;this.scrollTop+=30*(l<0?1:-1),o.preventDefault()}}),t(document).on("scroll",function(){100<t(this).scrollTop()?t(".scroll-to-top").fadeIn():t(".scroll-to-top").fadeOut()}),t(document).on("click","a.scroll-to-top",function(o){var e=t(this);t("html, body").stop().animate({scrollTop:t(e.attr("href")).offset().top},1e3,"easeInOutExpo"),o.preventDefault()})}(jQuery);
