/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
// import  $ from 'jquery';
require('bootstrap');
const $ = require('jquery');
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');
// require('@fortawesome/fontawesome-free/js/all');


// global.$ = global.jQuery = $;

// console.log('Hello Webpack Encore! Edit me in assets/js/app.js');

var $collectionHolder;

var $addTagButton = $('<button type="button" class="add_new_link">Add a new</button>');

var $newLinkLi = $('<li></li>').append($addTagButton);

jQuery(document).ready(function () {
    $collectionHolder = $('ul.news');
    $collectionHolder.append($newLinkLi);
    $collectionHolder.data('index', $collectionHolder.find(':input').length);
    $addTagButton.on('click', function (e) {
        addNewForm($collectionHolder, $newLinkLi);
    })
});