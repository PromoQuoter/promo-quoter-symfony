// JavaScript Document
var $ = jQuery.noConflict();

/* search.js
 ========================================================*/
var searchToggle = $('.open-search'),
    inputAnime = $(".form-search"),
    body = $('body');

searchToggle.on('click', function (event) {
    event.preventDefault();

    if (!inputAnime.hasClass('active')) {
        inputAnime.addClass('active');
    } else {
        inputAnime.removeClass('active');
    }
});

body.on('click', function () {
    inputAnime.removeClass('active');
});

var elemBinds = $('.open-search, .form-search');
elemBinds.bind('click', function (e) {
    e.stopPropagation();
});

/* End search.js
 ========================================================*/

// browse-button

$(document).on('click', '.browse', function () {
    var file = $(this).parent().parent().parent().find('.file');
    file.trigger('click');
});
$(document).on('change', '.file', function () {
    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});


//accordion

jQuery(function () {
    $(".expand").on("click", function () {
        $(this).next().slideToggle(200);
        $expand = $(this).find(">:first-child");

    });
});


