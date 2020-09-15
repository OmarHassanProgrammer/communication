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