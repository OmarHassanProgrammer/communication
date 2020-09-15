<?php 
    include "../init.php";

    if(isset($_GET['id'])) {
        if(isset($_GET['type'])) {
            if($_GET['type'] == "friend") {
                $stat = $con->prepare("SELECT * FROM messages_friend WHERE message_id = ?");
                $stat->execute(array($_GET['id']));

                if($stat->rowCount() > 0) {
                    $stat = $con->prepare("DELETE FROM messages_friend WHERE message_id = ?");
                    $stat->execute(array($_GET['id']));
                }
            } elseif ($_GET['type'] == "group") {
                $stat = $con->prepare("SELECT * FROM messages_group WHERE message_id = ?");
                $stat->execute(array($_GET['id']));

                if($stat->rowCount() > 0) {
                    $stat = $con->prepare("DELETE FROM messages_group WHERE message_id = ?");
                    $stat->execute(array($_GET['id']));
                }
            }
        }
    }