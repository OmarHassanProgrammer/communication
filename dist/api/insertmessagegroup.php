<?php
    include "../init.php";

    if(isset($_POST['message']) && isset($_POST['group_id']) && ($_POST['message'] != "")) {

        $message = addSlashes($_POST['message']);

        $stat = $con->prepare("INSERT INTO messages_group (group_id, sender_id, `message`) VALUES (?, ?, ?)");
        $stat->execute(array($_POST['group_id'], $id, $message));

        $id_stat = $con->prepare("SELECT message_id FROM messages_group ORDER BY message_id DESC");
        $id_stat->execute(array());
        $message_id = $id_stat->fetchAll()[0]['message_id'];

        $group_id = $_POST['group_id'];
        include "usersingroup.php";
        foreach($members as $member) {
            if($member['id'] != $id) {
                $insert = $con->prepare("INSERT INTO see_messages_group (message_id, group_id, `user_id`, `take_time`) VALUES (?, ?, ?, '0000-00-00 00:00:00')");
                $insert->execute(array($message_id, $group_id, $member['id']));
                /*******************************************************************/
                $notify = $con->prepare("DELETE FROM notifications WHERE taker = ? AND `type` = ?");
                $notify->execute(array($member['id'], "message")); 
                /***/
                $new_messages_stat = $con->prepare("SELECT messages_friend.*, users.name
                                                    FROM messages_friend
                                                    INNER JOIN users 
                                                    ON users.id = messages_friend.sender_id
                                                    where taker_id = ? AND take_time = '0000-00-00 00:00:00'");
                $new_messages_stat->execute(array($member['id']));
                $new_messages = $new_messages_stat->fetchAll();
                $num_messages = $new_messages_stat->rowCount();

                $new_messages_stat = $con->prepare("SELECT see_messages_group.*, groups.name
                                                    FROM see_messages_group
                                                    INNER JOIN groups 
                                                    ON groups.id = see_messages_group.group_id
                                                    where `user_id` = ? AND take_time = '0000-00-00 00:00:00'");
                $new_messages_stat->execute(array($member['id']));
                $new_messages += $new_messages_stat->fetchAll();
                $num_messages += $new_messages_stat->rowCount();
                /***/
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
                $notify_insert->execute(array($member['id'], $notification, "communicate.php?func=chat&type=friends", "message"));
                /***************************************************************************/
            }
        }

    }

    /*header("Location: ../chat.php?friend=" . $member['id']);
    exit();*/