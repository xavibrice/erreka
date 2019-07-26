/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
require('startbootstrap-sb-admin-2/vendor/fontawesome-free/css/all.min.css');
require('startbootstrap-sb-admin-2/css/sb-admin-2.css');
require('startbootstrap-sb-admin-2/vendor/datatables/dataTables.bootstrap4.min.css');


require('startbootstrap-sb-admin-2/vendor/bootstrap/js/bootstrap.bundle.min');
require('startbootstrap-sb-admin-2/vendor/jquery-easing/jquery.easing.min');
require('startbootstrap-sb-admin-2/js/sb-admin-2.min');
require('startbootstrap-sb-admin-2/vendor/datatables/jquery.dataTables.min');
require('startbootstrap-sb-admin-2/vendor/datatables/dataTables.bootstrap4.min');
require('startbootstrap-sb-admin-2/js/demo/datatables-demo');

console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

jQuery(document).ready(function () {
    jQuery('.add-another-collection-widget').click(function (e) {
        var list = jQuery(jQuery(this).attr('data-list-selector'));
        // Try to find the counter of the list or use the length of the list
        var counter = list.data('widget-counter') || list.children().length;

        // grab the prototype template
        var newWidget = list.attr('data-prototype');
        // replace the "__name__" used in the id and name of the prototype
        // with a number that's unique to your emails
        // end name attribute looks like name="contact[emails][2]"
        newWidget = newWidget.replace(/__name__/g, counter);
        // Increase the counter
        counter++;
        // And store it, the length cannot be used if deleting widgets is allowed
        list.data('widget-counter', counter);

        // create a new list element and add it to the list
        var newElem = jQuery(list.attr('data-widget-tags')).html(newWidget);
        newElem.appendTo(list);
    });
});