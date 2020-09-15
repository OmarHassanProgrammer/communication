<?php
    include "../init.php";

    if(isset($_GET['group'])) {

        $group = $_GET['group'];

        $stat = $con->prepare("SELECT messages_group.*, users.name, messages_group.message_id as id
                                FROM `messages_group`
                                INNER JOIN users ON messages_group.sender_id = users.id
                                WHERE group_id = ?
                                ORDER BY `messages_group`.`send_time` ASC");

        $stat->execute(array($group));
        $messages = $stat->fetchAll();

        foreach($messages as $m) {

            $message = stripslashes($m['message']);
            $message = str_replace(',', '_coma_', $message);
            $message = str_replace(';', '_semicoma_', $message);

            $time = $m['send_time']; 
            $duration = ceil( ((time() - strtotime($time)) / 60));

            if($duration < 1) {
                $duration_text = "now";
            } elseif($duration < 1440) {
                $duration_text = date("H~~i", strtotime($time));
            } elseif($duration < 518400) {
                $duration_text = date("j F - H~~i", strtotime($time));
            } elseif($duration > 518400) {
                $duration_text = date("j F Y - H~~i", strtotime($time));
            }


            echo ($m['name'] == $name? "me":$m['name']) . ',' . 
            $message . ',' . 
            $m['id'] . ',' . 
            $duration_text . ',' 
            . $m['message_type'] . ';';

        }

        include "seemessagesgroup.php";

    }