(function ($) {
    $('.color-picker').each(function() {
        $(this).iris({
            hide: false,
            change: function (event, ui) {
                $(event.target).css({
                    'background': ui.color.toString()
                });
            }
        }).css({
            "background": $(this).val()
        });
    });
})(jQuery);