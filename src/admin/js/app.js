(function ($) {
    $('.color-picker').iris({
        change: function(event, ui) {
            $(event.target).css({
                'background': ui.color.toString()
            });
        }
    });
})(jQuery);