<?php
    include '../init.php';

    if(isset($_GET['friend'])) {

        $me = $id;

        $myfriend = $_GET['friend'];

        $myfriend_stat = $con->prepare("SELECT `id` FROM users WHERE `id` = ?");
        $myfriend_stat->execute(array($myfriend));

        if($myfriend_stat->rowCount() > 0) {
            
            $stat = $con->prepare("DELETE FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
            $stat->execute(array($me, $myfriend, $me, $myfriend));

            $stat = $con->prepare("DELETE FROM messages_friend WHERE (sender_id = ? AND taker_id = ?) OR (taker_id = ? AND sender_id = ?)");
            $stat->execute(array($me, $myfriend, $me, $myfriend));

        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
        
    }