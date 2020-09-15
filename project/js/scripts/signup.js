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