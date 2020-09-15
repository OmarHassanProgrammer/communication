<?php
    include "../init.php";

    if(isset($_GET['id'])) {
        $stat = $con->prepare("SELECT * FROM see_messages_group WHERE message_id = ?");
        $stat->execute(array($_GET['id']));
        $users = $stat->fetchAll();

        foreach ($users as $user) {
            $user_id = $user['user_id'];
            include "getdatafromid.php";

            $time = $user['take_time']; 
            $duration = floor( ((time() - strtotime($time)) / 60));

            if($duration < 1) {
                $watched_text = "seen now";
            } elseif($duration < 1440) {
                $watched_text = "Seen at " . date("H~~i", strtotime($time));
            } elseif($duration < 518400) {
                $watched_text = "Seen at " . date("j F - H~~i", strtotime($time));
            } elseif($duration < 336673470432) {
                $watched_text = "Unseen yet ";
            } elseif($duration > 518400) {
                $watched_text = "Seen at " . date("j F Y - H~~i", strtotime($time));
            }

            echo $user_name . "," . $user_image . "," . $watched_text . ";";
        }
    }