(function ($) {
    //color picker
    $('.color-picker').each(function () {
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

    //slide
    const $handle = $('.slide__handle');
    const $input = $('input[name="wordpress-reading-bar-height"]');
    $('.slide').slider({
        min: 1,
        max: 80,
        value: $input.val().substring(0, $input.val().length - 2),
        create: function () {
            $handle.text($input.val());
        },
        slide: function (event, ui) {
            $handle.text(ui.value + 'px');
            $input.val($handle.text());
        }
    });
})(jQuery);