<?php
    include "../init.php";

    if(isset($_POST['message'])) {
        if(isset($_POST['friend_id'])) {
            if ($_POST['message'] != "") {
/*
                $message = addSlashes($_POST['message']);

                $stat = $con->prepare("INSERT INTO messages_friend (sender_id, taker_id, `message`, send_time) VALUES (?, ?, ?, NOW())");
                $stat->execute(array($id, $_POST['friend_id'], $message));

                $notify = $con->prepare("DELETE FROM notifications WHERE taker = ? AND `type` = ?");
                $notify->execute(array($_POST['friend_id'], "message"));*/

                /***/
                $new_messages_stat = $con->prepare("SELECT messages_friend.*, users.name
                                                    FROM messages_friend
                                                    INNER JOIN users 
                                                    ON users.id = messages_friend.sender_id
                                                    where taker_id = ? AND take_time = '0000-00-00 00:00:00'");
                $new_messages_stat->execute(array($_POST['friend_id']));
                $new_messages = $new_messages_stat->fetchAll();
                $num_messages = $new_messages_stat->rowCount();
                
                $new_messages_stat = $con->prepare("SELECT see_messages_group.*, users.name, messages_group.message_id
                                                    FROM see_messages_group
                                                    INNER JOIN messages_group
                                                    ON messages_group.message_id = see_messages_group.message_id
                                                    INNER JOIN users 
                                                    ON users.id = messages_group.sender_id
                                                    where `user_id` = ? AND take_time = '0000-00-00 00:00:00'");
                $new_messages_stat->execute(array($_POST['friend_id']));
                $new_messages += $new_messages_stat->fetchAll();
                $num_messages += $new_messages_stat->rowCount();
                /****/

                $notification = "There's is " . $num_messages . " messages from (";
                $names = array();
                foreach($new_messages as $new_message) {

                    if(!in_array($new_message['name'], $names)) {
                        $notification = $notification . " " . $new_message['name'] . ",";
                        array_push($names, $new_message['name']);
                    }
                }
                $notification = substr($notification, 0, strlen($notification) - 1);
                $notification = $notification . ")";

                $notify_insert = $con->prepare("INSERT INTO notifications (taker, `notification`,`link`, `type`) VALUES (?, ?, ?, ?)");
                $notify_insert->execute(array($_POST['friend_id'], $notification, "communicate.php?func=chat&type=friends", "message"));
            }
        }

    }