$(function () {
    var form = $('.login-form, .signup-form ')

    form.parent('body').css({
        'background-image': 'linear-gradient(#786fa6, #778beb)',
        'height': form.innerHeight() + 50
    });

    //if($(window).width() > 1024) {
        form.slideDown(600, function () {
            $(form).animate({
                left: ($('body').innerWidth() - form.width()) / 2
            }, 1400, function () {
                if(($('body').innerHeight() - (form.height() + 150)) > 0) {
                    form.animate({
                        top: ($('body').innerHeight() - (form.height() + 150)) / 2
                    }, 1300);
                }
            });
        });
    //}

});