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