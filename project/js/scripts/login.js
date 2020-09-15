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