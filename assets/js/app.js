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


/*
var $collectionHolder;

var $addTagButton = $('<button type="button" class="add_tag_link btn btn-primary">Añadir noticia</button>');
var $newLinkLi = $('<li></li>').append($addTagButton);
jQuery(document).ready(function() {
    // Get the ul that holds the collection of tags
    $collectionHolder = $('ul.news');

    // add a delete link to all of the existing tag form li elements
    $collectionHolder.find('li').each(function() {
        addTagFormDeleteLink($(this));
    });

    // add the "add a tag" anchor and li to the tags ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addTagButton.on('click', function(e) {
        // add a new tag form (see next code block)
        addTagForm($collectionHolder, $newLinkLi);
    });
});

function addTagForm($collectionHolder, $newLinkLi) {
    var prototype = $collectionHolder.data('prototype');

    var index = $collectionHolder.data('index');
    var newForm = prototype;

    newForm = newForm.replace(/__name__/g, index);
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    $newLinkLi.before($newFormLi);

    addTagFormDeleteLink($newFormLi);
}

function addTagFormDeleteLink($tagFormLi) {
    var $removeFormButton = $('<button class="btn btn-danger mb-1" type="button">Eliminar noticia</button>');
    $tagFormLi.append($removeFormButton);

    $removeFormButton.on('click', function(e) {
        // remove the li for the tag form
        $tagFormLi.remove();
    });
}
*/











// this variable is the list in the dom, it's initiliazed when the document is ready
var $collectionHolder;
// the link which we click on to add new items
var $addNewItem = $('<a href="#" class="btn btn-info">Añadir noticia</a>');
// when the page is loaded and ready
$(document).ready(function () {
    // get the collectionHolder, initilize the var by getting the list;
    $collectionHolder = $('#new_list');
    // append the add new item link to the collectionHolder
    $collectionHolder.append($addNewItem);
    // add an index property to the collectionHolder which helps track the count of forms we have in the list
    $collectionHolder.data('index', $collectionHolder.find('.panel').length)
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
    var $removeButton = $('<a href="#" class="btn btn-danger">Remove</a>');
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