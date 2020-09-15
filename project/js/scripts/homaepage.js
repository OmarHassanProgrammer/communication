$(function () {
    $(".home-page-header").parent('bhtmlody').css("height", '100vh');
    $(".home-page-header").parent('body').css("height", '100vh');

    $(".scroll").click(function () {

        $(".scroll").fadeOut();

        $(".home-page-header").addClass("collapsed");

        $(".home-page-header .nav-title h1").fadeIn(3000);

        $(".home-page-header .nav-buttons .btn-group").fadeIn(3000);

        $(".home-page-body").fadeIn(3000, function () {
            $("html").getNiceScroll().resize();
            animations();
        });

    });

    
    
    $('.mycomment .rate .star').click(function() {

        var rate = $(this).data('num');
        console.log(rate);

        $('#rate').val(rate);

        $('.star').each(function () {

            if($(this).data('num') <= rate) {
                $(this).find('svg').addClass('active');
            } else {
                $(this).find('svg').removeClass('active');
            }

        });

    });
});