
    $(".friends").on("click", ".friend", function() {

        location.assign("chat.php?friend=" + $(this).data("id"));

    });

    $(".friends").on("click", ".friend .settings", function (e) {
        e.stopPropagation();
        var friend = $(this).parents(".friend"),
            settings = $(".friends .friend-settings");

        settings.find(".remove-link").attr("href", "api/removefriend.php?friend=" + friend.attr("data-id"));
        settings.find(".block-link").addClass(
                (friend.find(".block-val").val() == "block-true"?"btn-success":"btn-danger")
            ).removeClass(
                (friend.find(".block-val").val() == "block-true"?"btn-danger":"btn-success")
            ).text(
                (friend.find(".block-val").val() == "block-true"?"Unblock him/her":"Block him/her")
            ).attr("href", "api/toggleblock.php?id=" + friend.attr("data-id"));

        settings.parent(".new_window_wrapper").fadeIn(700);
        settings.getNiceScroll().resize();
    });
        
    $(".friends").on("click", ".friend-settings .close", function () {
        $(".friends .friend-settings").parent(".new_window_wrapper").fadeOut(700);
    });

    $(".myfriends").on("click", ".friend", function() {

        location.assign("chat.php?friend=" + $(this).data("id"));

    });

    $(".chat_friend .send-btn").click(function(button) {

        button.preventDefault();
        
        $.post("api/insertmessagefriend.php", {
            friend_id: getParameterByName("friend"),
            message: encodeURIComponent($(".message-field").val())
        }, function (response) {

            getMessages_friends();

            $(".message-field").val("");

            setTimeout(function () {
                $(".messages").scrollTop($(".messages").prop("scrollHeight"));
            }, 400);

        });

    });

    $(".chat_friend .send-file-btn .file, .chat_group .send-file-btn .file").change(function () {
        $(this).parents("form").submit();
    });

    $(".communicate .search .button").click(function () {

        $(this).parents(".search").find(".content").slideToggle(1000, function () {
            $("html").getNiceScroll().resize();
        });
        $(this).find("svg").toggleClass("fa-arrow-down fa-arrow-up");

    });

    $(".communicate .form-search").submit(function (e) { 

        var search_form = $(this).parents(".search");
        if(search_form.siblings(".friends").length > 0) {

            e.preventDefault();

            var id = search_form.find("#id").val() == ""?"nono":search_form.find("#id").val(),
                name = search_form.find("#name").val() == ""?"nono":search_form.find("#name").val(),
                type = search_form.find("[name=friendtype]:checked").data("value") == undefined?"nono":search_form.find("[name=friendtype]:checked").data("value") ;

            $.post("api/getusers.php", {
                'id': id,
                'name': name,
                'type': "myfriends",
                'more-type': type
            }, function (response) {

                if(response != "") {

                    var friends = response.split(";");
                    friends.pop();
        
                    $(".nofriends").remove();

                    $(".friends .friends-content").css("display", "block").html(``);
                    
                    for(friend in friends) {
        
                        var data = friends[friend].split(",");

                            $(".friends .friends-content").html( $(".friends .friends-content").html() + 
                                `
                                <div class="friend row" data-id="` + data[0] + `">
                                    <input type="hidden" class="block-val" value="block-` + data[7] + `">
                                    <div class="left col-md-8">
                                        <img class="user-image" src="data/users_img/` + data[3] + `" alt="Logo">
                                        <h4 class="name">` + data[1] + `</h4>'
                                        ` +(data[5] == 0? '':`<span class="badge badge-danger new-messages">` + data[5] + `</span>`) +
                                        `<span class="date">1 hour ago</span>
                                    </div>
                                    <div class="right col-md-4 mb-2 mb-md-0">
                                        <a href="api/togglefav.php?id=` + data[0] + `&fav=` + data[4] + `">
                                            <i class="fas fa-heart favourite ` + (data[4] == 'true'? "active":"") + `"></i>
                                        </a>
                                        <button class="settings"><i class="fa fa-cog"></i></button>
                                        <a href="userprofile.php?id=` + data[0] + `"><i class="fas fa-info-circle info"></i></a>
                                    </div>
                                </div>
                            `);
                    }

                    lastlogin();

                    $("html").getNiceScroll().resize();
                    $("html").scrollTop(0);
                    $(".communicate .search .button").click();
                    
                } else {
                    $(".nofriends").remove();
                    $(".friends .friends-content").css("display", "none").after(`<div class="alert alert-danger text-center font-weight-bold nofriends">There's not any user</div>`);
                    
                    $("html").getNiceScroll().resize();
                    $("html").scrollTop(0);
                    $(".communicate .search .button").click();
                }
            });
        } else if ($(this).parents(".search").siblings(".groups").length > 0) {
            e.preventDefault();

            var id = search_form.find("#id").val() == ""?"nono":search_form.find("#id").val(),
                name = search_form.find("#name").val() == ""?"nono":search_form.find("#name").val(),
                type = search_form.find("[name=grouptype]:checked").data("value") == undefined?"nono":search_form.find("[name=grouptype]:checked").data("value") ;

            $.post("api/getgroups.php", {
                'id': id,
                'name': name,
                'type': "mygroups",
                'more-type': type
            }, function (response) {

                if(response != "") {

                    var groups = response.split(";");
                    groups.pop();
        
                    $(".nogroups").remove();

                    if($(window).width() > 768) {
                        $(".groups").css("display", "block").html(``);
                    } else {
                        $(".groups").css("display", "table").html(``);
                    }
        
                    for(group in groups) {
        
                        var data = groups[group].split(",");
                        
                            $(".groups").html( $(".groups").html() + 
                                ` <div class="group row" data-id="` + data[0] + `">
                                    <div class="left col-md-8">
                                        <img class="group-logo" src="data/groups_logo/` + data[2] + `" alt="Logo">
                                        <h4 class="name">` + data[1] + `</h4>`
                                        + (data[4] == 0? '':`<span class="badge badge-danger new-messages ml-2">` + data[4] + `</span>`) + `
                                    </div>
                                    <div class="right col-md-4 mb-2 mb-md-0"> 
                                        <a href="api/togglepin.php?id=` + data[0] + `&pin=` + data[3] + `">
                                            <i class="fas fa-thumbtack pin ` + (data[3] == 'true'? "active":"") + `"></i>
                                        </a>
                                        <a href="group.php?group=` + data[0] + `&t=details"><i class="fas fa-info-circle info"></i></a>

                                    </div>
                                </div> 
                        `);
                    }

                    $("html").getNiceScroll().resize();
                    $("html").scrollTop(0);
                    $(".communicate .search .button").click();
                    
                } else {
                    $(".nogroups").remove();
                    $(".groups").css("display", "none").after(`<div class="alert alert-danger text-center font-weight-bold nogroups">There's not any group</div>`);
                    
                    $("html").getNiceScroll().resize();
                    $("html").scrollTop(0);
                    $(".communicate .search .button").click();
                }
            });
        }
    });

$(function () {

    if($('.chat_friend').hasClass("chat_friend")) {

        getMessages_friends();

        setTimeout(function () {
            $(".chat_friend .messages").scrollTop(  $(".chat_friend .messages")[0].scrollHeight );
        }, 50);
        setInterval(function () {

            getMessages_friends();

        }, 5000);

    }

    $(".message-field").keydown(function (e) { 
        
        if((e.which) == 9) {
            $(".send-btn").click();
        }

    });

    $(".groups .group").on("click", function() {
        location.assign("group.php?group=" + $(this).data("id"));
    });
    

    /*********/
        if($('.chat_group').hasClass("chat_group")) {

            getMessages_groups();

            setTimeout(function () {
                $(".chat_group .messages").scrollTop( $(".chat_group .messages")[0].scrollHeight );
            }, 50);

            setInterval(function () {

                getMessages_groups();

            }, 5000);

        }

        $(".chat_group .send-btn").click(function(button) {

            button.preventDefault();

            $.post("api/insertmessagegroup.php", {
                group_id: getParameterByName("group"),
                message: encodeURIComponent($(".message-field").val())
            }, function (response) {

                getMessages_groups();

                $(".message-field").val("");

            });

        });

        $(".chat_group .group-setting-btn").click(function () {
            $(".chat_group .group-settings").parent(".new_window_wrapper").fadeIn(700);
            $(".chat_group .group-settings").getNiceScroll().resize();
        });
        
        $(".chat_group .group-settings .close").click(function () {
            $(".chat_group .group-settings").parent(".new_window_wrapper").fadeOut(700);
        });
        
        $(".change-logo input").change(function () {
            $(this).parent().siblings('img.group_logo').attr('src', URL.createObjectURL(event.target.files[0]));
        });
        
        $(".chat_group .group-settings form").submit(function (e) {
            $(".chat_group .group-settings form [name=description]").val(($(".chat_group .group-settings form [name=description]").val() == ""? "null":$(".groups .new-group-content .inputs #description").val()));

            var tojoin = $(".chat_group .group-settings form [name=join]:checked").data("value");
            $("#tojoin").val(tojoin);
        });
    /*************/
        var longClick;
        $(".chat_friend .messages").on({
            mouseup: function () {
                clearTimeout(longClick);
            }, mousedown: function (){
                var e = $(this);
                longClick = setTimeout(function () {
                                e.toggleClass("checked");
                            }, 600);
            }
        }, ".message");

        $(".chat_friend .messages").on("click", ".message .tools .delete-message", function (a) {
            $.get("api/deletemessage.php?type=friend&id=" + $(this).parents(".message").attr("data-id"));
            getMessages_friends();
        });

        if($("body").innerWidth() > 1000) {

            $(".chat_group .messages").on({
                mouseup: function () {
                    clearTimeout(longClick);
                }, mousedown: function (){
                    var e = $(this);
                    longClick = setTimeout(function () {
                                    e.toggleClass("checked");
                                }, 600);
                }
            }, ".message");
    
        } else {
            $(".chat_group .messages").on("click", ".message", function () {
                var e = $(this);
                e.toggleClass("checked");
            });

        }

        $(".chat_group .messages").on("click", ".message .tools .delete-message", function (a) {
            $.get("api/deletemessage.php?type=group&id=" + $(this).parents(".message").attr("data-id"));
            getMessages_groups();
        });

        $(".chat_group").on("click", ".show-seens-btn", function () {
            $(".chat_group .messages_seens").parent(".new_window_wrapper").fadeIn(700);
            $(".chat_group .messages_seens").getNiceScroll().resize();

            var messageId = $(this).parents(".message").attr("data-id");

            $.get("api/seenmessagesgroups.php?id=" + messageId, function (response) {
                var users = response.split(";");
                users.pop();

                $(".chat_group .messages_seens .content").html("");

                for (user in users) {

                    var userData = users[user].split(",");
                    var time = userData[2].replace("~~", ":");

                    $(".chat_group .messages_seens .content").html( $(".chat_group .messages_seens .content").html() + `
                        <div class="member">
                            <img src="data/users_img/` + userData[1] + `" class="image" />
                            <h4 class="name">` + userData[0] + `</h4>
                            <span class="seen ` + (time == "seen now"?"now":"") + (time == "Unseen yet"?"unseen":"") + `">` + time + `</span>
                        </div>
                    `);
                }
                $(".messages_seens").getNiceScroll().resize();

            });
        });
        
        $(".chat_group").on("click", ".messages_seens .close", function () {
            $(".chat_group .messages_seens").parent(".new_window_wrapper").fadeOut(700);
        });

        $(".emojis .emoji").click(function () {
            $(".message-field").val( $(".message-field").val() + $(this).text() );
        });

        $(".messages").on("click", " .message .image", function () {
            $(".viewer").parent(".new_window_wrapper").fadeIn(700);

            $(".viewer .content").html(`
                <img class="image" src="` + $(this).attr("src") + `">
            `);

            $(".viewer").getNiceScroll().resize();
        });

        $(".messages").on("click", " .message .video", function () {
            $(".viewer").parent(".new_window_wrapper").fadeIn(700);

            $(".viewer .content").html(`
                <video class="video" src="` + $(this).attr("src") + `" poster="data/images/video-poster.jpg" controls autoplay></video>
            `);

            $(".viewer").getNiceScroll().resize();
        });
        
        $(".viewer .close").click(function () {
            $(".viewer .content").html("");
            $(".viewer").parent(".new_window_wrapper").fadeOut(700);
        });

    });
$(function() {
    $('.communicate').parent('body').css({
        'background-image': 'linear-gradient(#80DEEA, #64B5F6, #26C6DA)',
        'background-size': 'cover',
        'height': "auto"
    });
    
    

});
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
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}

function getMessages_friends() {

    var checkedMessages = [];
    $(".chat_friend .messages .message.checked").each(function () {
        checkedMessages.push($(this).data('id'));
    });

    $.get("api/getmessages.php?friend=" + getParameterByName("friend"), function (response) {

        var messages = response.split(';');
        messages.pop();

        var firstTime = ($(".chat_friend .messages").html() == ""?true:false);
        $(".chat_friend .messages").html("");

        for(message in messages) {

            good_message = messages[message].split(',');
            var m;
            
            switch(good_message[5]) {
                case "text":
                    m = decodeURIComponent(good_message[1]).replace(/_coma_/g, ',');
                    m = m.replace(/_semicoma_/g, ';');
                    break;
                case "image":
                    m = `<img class="image" src="data/messages_files/` + good_message[1] + `">`;
                    break;
                case "video":
                    m = `<video class='video' src='data/messages_files/` + good_message[1] + `' poster="data/images/video-poster.jpg"></video>`;
                    break;
            }

            me = (good_message[0] == "me"? "me":"notme");
            var time = good_message[2].replace("~~", ":");
            var seenTime =  good_message[4].replace("~~", ":");

            var message_id = good_message[3];

            $(".chat_friend .messages").html(    $(".chat_friend .messages").html() + 
                    `
                        <div class="message ` + me + ` ` + (checkedMessages.includes(parseInt(message_id))?"checked":"") + `" data-id="` + message_id + `">
                            <div class="message-content">`
                                + m + 
                                `<span class="time ` + (time == "now"?"active":"") + `">` + time + `</span>
                            </div>
                            <div class="tools">
                                <span class="seen-time">` + seenTime + `</span>
                                <button class="delete-message">
                                    <i class="fas fa-prescription-bottle"></i>
                                </button>
                            </div>
                        </div>
                    `);

        }

        $(".messages .message.notme").each(function() {
            if(($(this).next(".message.notme").length == 0) & ($(this).prev(".message.notme").length == 0)) {
                $(this).addClass("lone-notme");
            }
            if(($(this).next(".message.notme").length != 0) & ($(this).prev(".message.notme").length != 0)) {
                $(this).addClass("middle-notme");
            }
            if($(this).next(".message.notme").length == 0) {
                if(!$(this).hasClass("lone-notme")) {
                    $(this).addClass("last-notme"); 
                }
            }
            if($(this).prev(".message.notme").length == 0) {
                if(!$(this).hasClass("lone-notme")) {
                    $(this).addClass("first-notme");
                }
            }
        });

        $(".messages .message.me").each(function() {
            if(($(this).next(".message.me").length == 0) & ($(this).prev(".message.me").length == 0)) {
                $(this).addClass("lone-me");
            }
            if(($(this).next(".message.me").length != 0) & ($(this).prev(".message.me").length != 0)) {
                $(this).addClass("middle-me");
            }
            if($(this).next(".message.me").length == 0) {
                if(!$(this).hasClass("lone-me")) {
                    $(this).addClass("last-me"); 
                }
            }
            if($(this).prev(".message.me").length == 0) {
                if(!$(this).hasClass("lone-me")) {
                    $(this).addClass("first-me");
                }
            }
        });

        $(".message.last-notme .message-content").css("--image", "url(../data/users_img/" + $(".his-image").html() + ")");
        $(".message.lone-notme .message-content").css("--image", "url(../data/users_img/" + $(".his-image").html() + ")");

        $(".message.last-me .message-content").css("--image", "url(../data/users_img/" + $(".my-image").html() + ")");
        $(".message.lone-me .message-content").css("--image", "url(../data/users_img/" + $(".my-image").html() + ")");

        $(".messages .message .audio, .messages .message .video, .messages .message .image").parent(".message-content").css("width", "80%");

        setTimeout(function () {
            $("html").getNiceScroll().resize();
            if(firstTime) {
                $(".messages").scrollTop($(".messages").prop("scrollHeight"));
            }
        }, 400);

    });

}

function animations() {
    
    var scroll = $(window).scrollTop();
    
    if(scroll >= ($(".what").offset().top - 500)) {
        $(".what .my-title").css("opacity", "1").addClass("animated fadeInLeft");
        setTimeout(function() {
            $(".what .content").css("opacity", "1").addClass("animated swing");
        }, 1000);
    }

    if(scroll >= ($(".about").offset().top - 500)) {

        setTimeout(function() {
            $(".about .my-title").css("opacity", "1").addClass("animated fadeInLeft");
            setTimeout(function() {
                $(".about .content").css("opacity", "1").addClass("animated swing");
            }, 1000);
        }, 1000);
    }

    if(scroll >= ($(".features").offset().top - 500)) {

        setTimeout(function() {
            $(".features .my-title").css("opacity", "1").addClass("animated fadeInLeft");
            var g = 0;

            for(var i = 0; i < $(".features .content").find(".feature").length; i++) {

                setTimeout(function () {    
                    var feature = $(".features .content").find(".feature")[g];
                    $(feature).css("opacity", "1").addClass("animated rotateIn");
                    g++;
                }, i * 1000 + 1000);
            };
        }, 1000);
    }

    if(scroll >= ($(".comments").offset().top - 500)) {

        setTimeout(function() {
            $(".comments .my-title").css("opacity", "1").addClass("animated fadeInLeft");
            setTimeout(function() {
                $(".comments .content").css("opacity", "1").addClass("animated shake");
            }, 1000);
        }, 1500);
    }

    if(scroll >= ($(".mycomment").offset().top - 700)) {

        setTimeout(function() {
            $(".mycomment .my-title").css("opacity", "1").addClass("animated fadeInLeft");
            setTimeout(function() {
                $(".mycomment .content").css("opacity", "1").addClass("animated bounce");
            }, 1000);
        }, 1000);
    }
    
    if(scroll >= ($(".footer").offset().top - 1000)) {

        setTimeout(function() {
            $(".footer .rights").css("opacity", "1").addClass("animated rubberBand");
            $(".footer .data .left").css("opacity", "1").addClass("animated bounceInLeft delay-1s");
            $(".footer .data .right").css("opacity", "1").addClass("animated bounceInLeft delay-2s");

        }, 1000);
    }
    

}

function lastlogin() {

    $.post("api/makeonline.php");
    
    $.each($(".friends .friend, .my-friend"), function (index, friend) { 
        $.post("api/lastlogin.php", {
            'user_id': $(friend).data("id")
        }, function (response) {
            if(response == "online") {
                $(friend).find(".date").addClass("online");
            }
            $(friend).find(".date").text(response);
        });
    });
}


function getMessages_groups() {

    $.get("api/getmessagesgroup.php?group=" + getParameterByName("group"), function (response) {

        var checkedMessages = [];
        var firstTime = ($(".chat_friend .messages").html() == ""?true:false);
    
        $(".chat_group .messages .message.checked").each(function () {
            checkedMessages.push($(this).data('id'));
        });

        var messages = response.split(';');
        messages.pop();

        $(".chat_group .messages").html("");
        

        for(message in messages) {

            good_message = messages[message].split(',');
            var m;
            
            switch(good_message[4]) {
                case "text":
                    m = decodeURIComponent(good_message[1]).replace(/_coma_/g, ',');
                    m = m.replace(/_semicoma_/g, ';');
                    break;
                case "image":
                    m = `<img class="image" src="data/messages_files/` + good_message[1] + `">`;
                    break;
                case "video":
                    m = `<video class='video' src='data/messages_files/` + good_message[1] + `' poster="data/images/video-poster.jpg"></video>`;
                    break;
            }

            me = (good_message[0] == "me"? "":"notme");
            var time = good_message[3].replace("~~", ":");

            $(".chat_group .messages").html(    $(".chat_group .messages").html() + 
                                                `
                                                    <div class="message ` + me + ` ` +  (checkedMessages.includes(parseInt(good_message[2]))?"checked":"")  +` ` + good_message[0].replace(" ", "_") +`" data-id="` + good_message[2] + `">
                                                        <div class="message-content">`
                                                            + m + 
                                                            `<span class="time ` + (time == "now"?"active":"") + `">` + time + `</span>
                                                        </div>
                                                        <div class="tools">
                                                            <button class="show-seens-btn">
                                                                <i class="fas fa-eye"></i>
                                                            </button>
                                                            <button class="delete-message">
                                                                <i class="fas fa-prescription-bottle"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                `);

        }

        $(".messages .message.notme").each(function() {
            var id = $(this).data("id");
            if(($(this).next(".message.notme[data-id=" + id + "]").length == 0) & ($(this).prev(".message.notme[data-id=" + id + "]").length == 0)) {
                $(this).addClass("lone-notme");
            }
            if(($(this).next(".message.notme[data-id=" + id + "]").length != 0) & ($(this).prev(".message.notme[data-id=" + id + "]").length != 0)) {
                $(this).addClass("middle-notme");
            }
            if($(this).next(".message.notme[data-id=" + id + "]").length == 0) {
                if(!$(this).hasClass("lone-notme")) {
                    $(this).addClass("last-notme"); 
                }
            }
            if($(this).prev(".message.notme[data-id=" + id + "]").length == 0) {
                if(!$(this).hasClass("lone-notme")) {
                    $(this).addClass("first-notme");
                }
            }
        });

        $(".messages .message.me").each(function() {
            if(($(this).next(".message.me").length == 0) & ($(this).prev(".message.me").length == 0)) {
                $(this).addClass("lone-me");
            }
            if(($(this).next(".message.me").length != 0) & ($(this).prev(".message.me").length != 0)) {
                $(this).addClass("middle-me");
            }
            if($(this).next(".message.me").length == 0) {
                if(!$(this).hasClass("lone-me")) {
                    $(this).addClass("last-me"); 
                }
            }
            if($(this).prev(".message.me").length == 0) {
                if(!$(this).hasClass("lone-me")) {
                    $(this).addClass("first-me");
                }
            }
        });


        $(".message.last-me .message-content").css("--image", "url(../data/users_img/" + $(".my-image").html() + ")");
        $(".message.lone-me .message-content").css("--image", "url(../data/users_img/" + $(".my-image").html() + ")");


        var users = [];
        $(".users_image div").each(function () {
            if(!(users.includes($(this).attr("class").split(" ")[0]))) {
                users.push($(this).attr("class").split(" ")[0]);
            }
        });

        for(user in users) {
            $(".message.last-notme." + users[user] + " .message-content").css("--image", "url(../data/users_img/" + $(".users_image ." + users[user]).html() + ")");
            $(".message.lone-notme." + users[user] + " .message-content").css("--image", "url(../data/users_img/" + $(".users_image ." + users[user]).html() + ")");

            $(".message.first-notme." + users[user] + " .message-content").prepend("<span class='text-secondary font-weight-bold d-block'>" + users[user].replace("_", " ") + "</span>");
            $(".message.lone-notme." + users[user] + " .message-content").prepend("<span class='text-secondary font-weight-bold d-block'>" + users[user].replace("_", " ") + "</span>");

        }
        
        setTimeout(function () {
            $("html").getNiceScroll().resize();
            if(firstTime) {
                $(".messages").scrollTop($(".messages").prop("scrollHeight"));
            }
        }, 600);


    });

}

function window_wrap () {
    $(".new_window").wrap('<div class="new_window_wrapper"></div>');
}

window_wrap();

function make_notification () {
    
    $.get("api/newnotifies.php", function(newnotifies) {
        $(".notification .notify-btn").addClass(newnotifies);
    });

    $.post("api/getnotifications.php", function (response) {

        if(response != "") {

            var notifications = response.split(";");
            notifications.pop();

            $(".notifies").html(``);

            for(notification in notifications) {

                var data = notifications[notification].split(":");
                data[4] = data[4].replace("~~", ":")
                var icon = "";

                switch(data[3]) {
                    case "friend_request":
                        icon = '<i class="fas fa-user-friends"></i>';
                        break;
                    case "friend_request_accepted":
                        icon = '<i class="fas fa-user-check"></i>'
                        break;
                    case "message":
                        icon = '<i class="fas fa-envelope"></i>';
                        break;
                }

                $(".notifies").html( $(".notifies").html() + 
                    `
                    <a class="dropdown-item notify" href="` + data[2] + `">
                        <span class="sr-only id">` + data[0] + `</span>`
                        + icon
                        + `<span class="content">` + data[1] + `</span>
                        <span class="date">` + data[4] + `</span>
                    </a>

                `);
            }

        }

    });
}
$(function () {

    $(".new-group-content .close").click(function () {
        $(".new_window_wrapper").fadeOut(700);
    });

    $(".new-group-button").click(function () {
        $(".new_window_wrapper").fadeIn(700);
    });

    $(".groups .members ").on("click", ".member .delete", function (e) {
        e.preventDefault();
        $(this).parent(".member").detach();

        var friend = $(this).parent(".member");

        $(".groups .myfriends").html($(".groups .myfriends").html() + `
            <div class="myfriend" data-id="` + $(friend).data("id") + `" data-name="` + $(friend).data("name") + `" data-image="` + $(friend).data("image") + `">
                <img class="user-image" src="data/users_img/` + $(friend).data("image") + `" alt="Logo">
                <h4 class="name">` + $(friend).data("name") + `</h4>
            </div>
        `);
    });

    $(".groups .members .add-member").click(function (e) {
        e.preventDefault();
        $(".groups .myfriends").addClass("open");
    });

    $(".groups .myfriends .close").click(function () {
        $(".groups .myfriends").removeClass("open");
    });

    $(".groups .myfriends ").on("click", ".myfriend", function (e) {
        e.preventDefault();

        var friend = $(this);

        $(".groups .members .added-members").html( $(".groups .members .added-members").html() + `        
            <span class="member" data-id="` + $(friend).data("id") + `" data-name="` + $(friend).data("name") +`" data-image="` + $(friend).data("image") + `">
                ` + $(friend).data("name") + `
                <button class="delete"><i class="far fa-times-circle"></i></button>
            </span>
        `);

        $(friend).detach();
    });

    $(".groups .new-group-content form").submit(function (e) {
        $(".groups .new-group-content .inputs #description").val(($(".groups .new-group-content .inputs #description").val() == ""? "null":$(".groups .new-group-content .inputs #description").val()));

        var members = "";
        $(".groups .members .added-members .member").each(function () {
            members = members + $(this).data("id") + ",";
        });
        $("#membersingroup").val(members);

        var tojoin = $(".groups .new-group-content [name=join]:checked").data("value");
        $("#tojoin").val(tojoin);
    });

    $("#group_logo").change(function () {
        $(this).parent().siblings('img').attr('src', URL.createObjectURL(event.target.files[0]));
    });

    $(".groups .form-search").submit(function (e) { 
        e.preventDefault();

        var id = $(".groups .id").val() == ""?"nono":$(".groups .id").val(),
            name = $(".groups .search .name").val() == ""?"nono":$(".groups .search .name").val(),
            type = $(".groups [name=grouptype]:checked").data("value") == undefined?"nono":$(".groups [name=grouptype]:checked").data("value") ;

        $.post("api/getgroups.php", {
            'id': id,
            'name': name,
            'type': type
        }, function (response) {

            if(response != "") {

                var groups = response.split(";");
                groups.pop();
    
                $(".nogroups").remove();
                if($(window).width() > 768) {
                    $(".groups table").css("display", "table").find("tbody").html(``);
                } else {
                    $(".groups table").css("display", "block").find("tbody").html(``);
                }

                var round = 0,
                    ids = [],
                    names = [],
                    logos = [],
                    buttons = [];

                for(group in groups) {
                    
                    var data = groups[group].split(",");
                    var button = "";
                    
                    if(data[5] == "no-direct") {
                        button = '<a class="btn mr-md-2 mb-1 mb-md-0 btn-success" href="api/joingroup.php?group=' + data[0] + '">Join to group</a>';
                    } else if (data[5] == "no-request") {
                        button = '<a class="btn mr-md-2 mb-1 mb-md-0 btn-info" href="api/joingroup.php?group=' + data[0] + '">Send a request</a>';
                    } else if (data[5] == "request") {
                        button = '<a class="btn mr-md-2 mb-1 mb-md-0 btn-warning" href="api/leavegroup.php?group=' + data[0] + '">Cancel the request</a>';
                    } else if (data[5] == "member") {
                        button = '<a class="btn mr-md-2 mb-1 mb-md-0 btn-danger" href="api/leavegroup.php?group=' + data[0] + '">Leave group</a>';
                    }
                    buttons.push(button);
                    ids.push(data[0]);
                    names.push(data[1]);
                    logos.push(data[2]);
                    
                    $.post("api/usersingroup.php", {
                        'group_id': data[0]
                    }, function (response) {
                        

                        var members = response.split(";");
                        members.pop();
                        var membersCode = "";

                            for(member in members) {
                                members_data = members[member].split(',');
                                membersCode = membersCode + "<span class='member "  + members_data[1]  + " "  + (members_data[0] == $("#my-name").text() ?"me":"")   + "' title='"  + (members_data[1] == "n_member"? "member":members_data[1])  + "'>"  + (members_data[0] == $("#my-name").text() ?"me":members_data[0])  + "</span>";
                            }

                            $(".groups table tbody").html( $(".groups table tbody").html() + 
                                `
                                <tr> 
                                    <td>` + ids[round] + `</td>
                                    <td><img class="group-logo" src="data/groups_logo/` + logos[round] + `"></td>
                                    <td>` + names[round] + `</td>
                                    <td>` + membersCode + `</td>
                                    <td>
                                        ` + buttons[round] + `
                                        <a class="btn btn-primary">Details</a>
                                    </td>
        
                                </tr>
                            `);
                            round++;
                    });
    
                }

                $("html").getNiceScroll().resize();
                $("html").scrollTop(0);
                $(".groups .search .button").click();
                
            } else {
                $(".nogroups").remove();
                $(".groups table").css("display", "none").after(`<div class="alert alert-danger text-center font-weight-bold nogroups">There's not any group</div>`);
                
                $("html").getNiceScroll().resize();
                $("html").scrollTop(0);
                $(".groups .search .button").click();
            }
        });
    });


});
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
$(function () {

    if($("body").has(".myfriends").length > 0) {

        lastlogin();

        setInterval(function () {
            
            lastlogin();

        }, 300000);

    } else if($("body").find(".friends").length > 0) {
        
        lastlogin();

        setInterval(function () {
            
            lastlogin();

        }, 300000);

    }

});
$(function () {
    var loginform = $('.login-form');
    $(loginform).submit(function(e) {
        
        e.preventDefault();
        var _username = $('#username').val(),
            _password = $('#password').val();

        $.post('api/login.php', {
                username: _username,
                password: _password
                } , function(response) {
                    if(response != 'error')
                        location.assign('communicate.php');
        });

    });
});
$(function () {

    $('.notifies').on('click', '.notify', function () {

        $.get("api/deletenotify.php?notify_id=" + $(this).find('.id').text());

    });

    setInterval(function () {
        make_notification();
    }, 5000);

    setTimeout(function () {
        make_notification();
    }, 600);

    $(".notification .notify-btn").click(function () {

        $.get("api/seenotifies.php");

        $(this).removeClass("new-notifies");

    });

});
$(function () {
    var signup = $('.signup-form');
    $(signup).submit(function(e) {
        
        $('#email').val($('#email').val() == ''? 'null' : $('#email').val());

    });
});



$(function () {

    $("#user_img").change(function () {
        $(this).parent().siblings('img').attr('src', URL.createObjectURL(event.target.files[0]));
    });

    $(".update_user_image").change(function () {
        $(this).parents("form")[0].submit();
    });

});
$(function () {

    $(".users .form-search").submit(function (e) { 
        e.preventDefault();

        var id = $(".users #id").val() == ""?"nono":$(".users #id").val(),
            name = $(".users #name").val() == ""?"nono":$(".users #name").val(),
            type = $(".users [name=usertype]:checked").data("value") == undefined?"nono":$(".users [name=usertype]:checked").data("value") ;

        $.post("api/getusers.php", {
            'id': id,
            'name': name,
            'type': type
        }, function (response) {

            if(response != "") {

                var users = response.split(";");
                users.pop();
    
                $(".nousers").remove();

                if($(window).width() > 768) {
                    $(".users table").css("display", "table").find("tbody").html(``);
                } else {
                    $(".users table").css("display", "block").find("tbody").html(``);
                }
    
                for(user in users) {
    
                    var data = users[user].split(",");
                    var button = "";
                    if(data[0] != $(".my-id").text()) {
                        if((data[6] == 'no') || ((data[6] == "sender") && (data[6] == "unfriend_1")) || ((data[6] == "taker") && (data[6] == "unfriend_2"))) {
                            button = '<a class="btn btn-success mr-2 mb-1 mb-md-0" href="api/addfriend.php?friend=' + data[0] + '">Add friend</a>';
                        } else if(data[6] == 'friends') {
                            button = '<a class="btn btn-danger mr-2 mb-1 mb-md-0" href="api/changefriendstatus.php?friend=' + data[0] + '&status=unfriend">Remove friend</a>';
                        } else if(data[6] == 'sender') {
                            button = '<a class="btn btn-warning mr-2 mb-1 mb-md-0" href="api/removefriend.php?friend=' + data[0] + '">Cancel the request</a>';
                        } else if(data[6] == 'taker') {
                            button = '<a class="btn btn-info mr-2 mb-1 mb-md-0" href="api/changefriendstatus.php?friend=' + data[0] + '&status=friends">Accept the request</a>';
                        } else if(((data[0] == $(".my-id").text()) && (data[6] == "unfriend_2")) || ((data[0] != $(".my-id").text()) && (data[6] == "unfriend_1"))) {

                            button = '<a class="btn btn-danger mr-2 mb-1 mb-md-0" href="api/removefriend.php?friend=' + data[0] + '">Your friend unfriend you</a>';

                        }
                    }
    
                    $(".users table tbody").html( $(".users table tbody").html() + 
                        `
                        <tr `+ (data[0] == $(".my-id").text()? 'class="active"':'') + `> 
                            <td>` + data[0] + `</td>
                            <td>` + data[1] + `</td>
                            <td>` + data[2] + `</td>
                            <td><img class="user-img" src="data/users_img/` + data[3] + `"></td>
                            <td>
                                ` + button + `
                                <a class="btn btn-primary">Details</a>
                            </td>

                        </tr>
                    `);

                    console.log(data[6]);
                }

                $("html").getNiceScroll().resize();
                $("html").scrollTop(0);
                $(".users .search .button").click();
                
            } else {
                $(".nousers").remove();
                $(".users table").css("display", "none").after(`<div class="alert alert-danger text-center font-weight-bold nousers">There's not any user</div>`);
                
                $("html").getNiceScroll().resize();
                $("html").scrollTop(0);
                $(".users .search .button").click();
            }
        });
    });

});