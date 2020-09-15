<?php
    include "../init.php";

    if(isset($_GET['friend'])) {

        $friend = $_GET['friend'];

        $stat = $con->prepare("SELECT messages_friend.*, users.name 
                                FROM `messages_friend`
                                INNER JOIN users ON messages_friend.sender_id = users.id
                                WHERE (sender_id = ? AND taker_id = ?) OR (taker_id = ? AND sender_id = ?) 
                                ORDER BY `messages_friend`.`send_time` ASC");

        $stat->execute(array($id, $friend, $id, $friend));
        $messages = $stat->fetchAll();

        foreach($messages as $m) {

            $message = stripslashes($m['message']);
            $message = str_replace(',', '_coma_', $message);
            $message = str_replace(';', '_semicoma_', $message);
            
            $time = $m['send_time']; 
            $duration = floor( ((time() - strtotime($time)) / 60));

            if($duration < 1) {
                $duration_text = "now";
            } elseif($duration < 1440) {
                $duration_text = date("H~~i", strtotime($time));
            } elseif($duration < 518400) {
                $duration_text = date("j F - H~~i", strtotime($time));
            } elseif($duration > 518400) {
                $duration_text = date("j F Y - H~~i", strtotime($time));
            }

            $time = $m['take_time']; 
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


            echo ($m['name'] == $name? "me":$m['name']) . 
            ',' . $message . ',' . $duration_text . ',' 
            . $m['message_id'] . ',' . $watched_text . ',' .
            $m['message_type'] . ';';

        }

        include "seemessages.php";

        /*echo "<pre>";
        print_r($messages);*/

    }