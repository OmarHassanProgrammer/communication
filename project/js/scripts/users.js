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