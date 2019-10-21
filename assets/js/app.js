/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// import  $ from 'jquery';
require('bootstrap');
require('datatables.net');
require('bootstrap-datepicker');

const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');

const routes = require('../../public/js/fos_js_routes');
// const Routing = require('./Components/Routing');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router';
// require('@fortawesome/fontawesome-free/js/all');

// global.$ = global.jQuery = $;

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

$(document).ready(function() {
    $('#dataTable').DataTable( {
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

(function($){
    $.fn.datepicker.dates['es'] = {
        days: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
        daysShort: ["Dom", "Lun", "Mar", "Mié", "Jue", "Vie", "Sáb"],
        daysMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
        months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
        today: "Hoy",
        monthsTitle: "Meses",
        clear: "Borrar",
        weekStart: 1,
        format: "dd/mm/yyyy"
    };
}(jQuery));

var date = new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$(document).ready(function() {
    // you may need to change this code if you are not using Bootstrap Datepicker
    $('.js-datepicker').datepicker({
        language: 'es',
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
    });
    $('.js-datepicker').datepicker('setDate', today);
});

$(document).ready(function() {
    // you may need to change this code if you are not using Bootstrap Datepicker
    $('.js-datepicker-empty').datepicker({
        language: 'es',
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        autoclose: true,
    });
});

document.addEventListener('DOMContentLoaded', () => {
    var calendarEl = document.getElementById('calendar-holder');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        defaultView: 'dayGridMonth',
        selectable: true,
        editable: true,
        locale: 'es',
        eventSources: [
            {
                url: "/fc-load-events",
                method: "POST",
                extraParams: {
                    filters: JSON.stringify({})
                },
                failure: () => {
                    // alert("There was an error while fetching FullCalendar!");
                },
            },
        ],
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay',
        },
        plugins: [ 'interaction', 'dayGrid', 'timeGrid' ], // https://fullcalendar.io/docs/plugin-index
        timeZone: 'UTC',
    });
    calendar.render();
});


$("#property_situation").change(function () {
    const data = {
        situation_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin2/situation/situation_reason',
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
        url: '/admin2/situation/situation_reason',
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
        url: '/admin2/zone/zone_street',
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
        url: '/admin2/zone/zone_street',
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

$("#property_charge_two_zone").change(function () {
    const data = {
        zone_id: $(this).val()
    };
    $.ajax({
        type: 'post',
        url: '/admin2/zone/zone_street',
        data: data,
        success: function (data) {
            if (data.length) {
                const $reason_selector = $('#property_charge_two_street');
                $reason_selector.html('<option> Selecciona...</option>');
                for (let i = 0, total = data.length; i < total; i++) {
                    $reason_selector.append('<option value="' + data[i].id + '">' + data[i].name + '</option>');
                }
            } else {
                const $reason_selector = $('#property_charge_two_street');
                $reason_selector.html('<option> Selecciona primero una zona</option>');
            }
        }
    });

});
