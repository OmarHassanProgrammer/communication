<?php
    if($_SERVER['REQUEST_METHOD'] == "GET") {
        
        $me = $id;
        if($type == "friend") {
            if(isset($user_id)) {
                
                $stat = $con->prepare("SELECT * FROM messages_friend WHERE `sender_id` = ? AND taker_id = ? AND `take_time` = '0000-00-00 00:00:00'");
                $stat->execute(array($user_id, $me));

                $newmessages =  $stat->rowCount();
                
            }
        } elseif ($type == "group") {
            if(isset($group_id)) {
                
                $stat = $con->prepare("SELECT * FROM see_messages_group WHERE group_id = ? AND `user_id` = ? AND take_time = '0000-00-00 00:00:00'");
                $stat->execute(array($group_id, $me));
                
                $newmessages =  $stat->rowCount();
                
            }
        }
    } elseif($_SERVER['REQUEST_METHOD'] == "POST" && !isset($type)) {

        include '../init.php';
        
        $me = $id;
        if($_POST['type'] == "friend") {
            if(isset($_POST['friend_id'])) {
                
                $stat = $con->prepare("SELECT * FROM messages_friend WHERE `sender_id` = ? AND taker_id = ? AND `take_time` = '0000-00-00 00:00:00'");
                $stat->execute(array($_POST['friend_id'], $id));

                echo $stat->rowCount();

            }
        } elseif ($_POST['type'] == "group") {
            if(isset($_POST['group_id'])) {

                $stat = $con->prepare("SELECT * FROM see_messages_group WHERE group_id = ? AND `user_id` = ? AND take_time = '0000-00-00 00:00:00'");
                $stat->execute(array($_POST['group_id'], $me));

                echo $stat->rowCount();

            }
        }

    } elseif (isset($type)) {
        include '../init.php';
        
        $me = $id;
        if($type == "friend") {
            if(isset($user_id)) {
                
                $stat = $con->prepare("SELECT * FROM messages_friend WHERE `sender_id` = ? AND taker_id = ? AND `take_time` = '0000-00-00 00:00:00'");
                $stat->execute(array($user_id, $id));

                $newmessages = $stat->rowCount();

            }
        } elseif ($type == "group") {
            if(isset($group_id)) {

                $stat = $con->prepare("SELECT * FROM see_messages_group WHERE group_id = ? AND `user_id` = ? AND take_time = '0000-00-00 00:00:00'");
                $stat->execute(array($group_id, $me));

                $newmessages = $stat->rowCount();

            }
        }
    }