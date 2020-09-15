<?php 
    include 'init.php';
    $title = 'Communicate';

    if(!isset($_GET['func'])) {
        header('Location: communicate.php?func=chat');
        exit();
    }

    $linkactive = '';
    switch($_GET['func']) {
        case 'chat':
        default:
            $linkactive = 'chat';
            break;
        case 'users':
            $linkactive = 'users';
            break;
        case 'groups':
            $linkactive = 'groups';
            break;
    }

    include 'includes/layouts/header.php';
    include 'includes/layouts/navbar.php';
?>

    <div class="communicate">

    <?php

        $func = $_GET['func'];

        switch($func) {
            case 'users':
                include 'includes/layouts/communicate/users.php';
                break;
            case 'chat':
                include "includes/layouts/communicate/chat.php";
                break;
            case 'groups':
                include "includes/layouts/communicate/groups.php";
                break;
        }

    ?>

    </div>

<?php

    include 'includes/layouts/footer.php';