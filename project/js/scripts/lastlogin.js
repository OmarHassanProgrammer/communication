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