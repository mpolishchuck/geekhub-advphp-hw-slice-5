function show_more_handler()
{
    var thisLink = $(this);
    thisLink.off('click').on('click', function () {return false;});
    thisLink.animate({'opacity': 0.1}, 100, 'swing', function () {
        $.ajax({
            'url' : thisLink.attr('href'),
            'async' : true,
            'dataType' : 'html',
            'type' : 'GET',
            'error' : function () {
                thisLink
                    .animate({'opacity': 1}, 100)
                    .off('click')
                    .on('click', show_more_handler);
            },
            'success' : function (data) {
                $(data)
                    .hide()
                    .appendTo(thisLink.closest('#posts-container'))
                    .fadeIn()
                    .find('#gb_show_more')
                    .on('click', show_more_handler);
                thisLink.remove();
            }
        });
    });
    return false;
}

$(document).ready(function () {
    $('#gb_show_more').on('click', show_more_handler);
});
