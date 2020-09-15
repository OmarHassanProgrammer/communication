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