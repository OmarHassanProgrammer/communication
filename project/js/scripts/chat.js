
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