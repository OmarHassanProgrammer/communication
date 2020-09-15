var placeholder;

$('input').focus(function() {
    placeholder = $(this).attr('placeholder');
    $(this).attr('placeholder', '');
});

$("input").blur(function () {
    $(this).attr('placeholder', placeholder)
});

$('input:not([type=submit])[required]').each(function () {

    $(this).wrap("<div class='input-req'></div>");
        
    $(this).each(function (index, element) {

        var responsiveclasses = element.classList.value.split(' ').filter(resclass => resclass.match(/col-\w*-?[0-9]/));

        if (responsiveclasses.length > 0) {
            $(element).parent('.input-req').addClass(responsiveclasses);
            $(element).removeClass(responsiveclasses);
        }
    });
});

$("input[required]").each(function () {
    $(this).after('<span class="req">*</span>');
});

$(function() { 


    $("html").niceScroll({
        cursorcolor:"#50a",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".message-field").niceScroll({
        cursorcolor:"#05a",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".chat_group .groups").niceScroll({
        cursorcolor:"#05a",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".chat_friend .myfriends").niceScroll({
        cursorcolor:"#05a",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".emojis").niceScroll({
        cursorcolor:"#00f",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".messages").niceScroll({
        cursorcolor:"#00f",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".group-settings").niceScroll({
        cursorcolor:"#00f",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });

    $(".messages_seens").niceScroll({
        cursorcolor:"#00f",
        cursoropacitymin: .5,
        cursorborder: "none",
        cursorwidth: "6px"
    });
    
    $('.comments .content').slick({
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 2,
            autoplay: true,
            autoplaySpeed: 2500,
            infinite: true,
            centerMode: true,
            centerPadding: '40px',
            responsive: [
                {
                    breakpoint: 1441,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                },
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        centerMode: false,
                        centerPadding: '0px',
                    }
                },
                {
                    breakpoint: 769,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        centerMode: false,
                        centerPadding: '0px',
                    }
                },
                {
                    breakpoint: 678,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: false,
                        centerPadding: '0px',
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        centerMode: false,
                        centerPadding: '0px',
                    }
                }
            ]
    });

    $(window).on("scroll", function () {
        if($(".home-page-body").length != 0) {
            animations();
        }
    });

    $(".stat-number").each(function () {
        var number = $(this).data('value').trim();
        var count = -1;
        var speed = (3000 / number);
        var element = $(this);
        var counter = setInterval(function () {
            count += 1;
            element.text(count);
            if(count == number) {
                clearInterval(counter);
            }
        }, speed);
    });
});
