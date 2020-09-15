<?php
    include "../init.php";
    
    if(isset($_FILES['file']) && isset($_POST['group_id'])) {
        $file = $_FILES['file'];
        $errors = array();

        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];

        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));

        $filename = time() . '.' . $extension;

        $file_path = $_SERVER['DOCUMENT_ROOT'] . "/data/messages_files/" . $filename;

        if($file['error'] == 4) {
            
            array_push($errors, "There isn't file upoloaded");

        } else {

            if($file_size > 25000000) {
                array_push($errors, "The size of the file can't be bigger than 250 kb");
            }
        
            if(empty($errors)) {
                if(in_array($extension, array("png", "jpg", "gif", "jpeg", "jfif"))) {
                    $stat = $con->prepare("INSERT INTO messages_group 
                                            (sender_id, group_id, `message`, message_type)
                                            VALUES (?, ?, ?, 'image')");
                    $stat->execute(array($id, $_POST['group_id'], $filename));
                } elseif(in_array($extension, array("mpg", "mpeg", "mpe", "mpv", "ogg", "mp4", "m4p", "m4v", "avi", "wmv", "mov", "qt", "flv", "swf"))) {
                    $stat = $con->prepare("INSERT INTO messages_group 
                                            (sender_id, group_id, `message`, message_type)
                                            VALUES (?, ?, ?, 'video')");
                    $stat->execute(array($id, $_POST['group_id'], $filename));
                } else {
                    array_push($errors, "The File must be video or image");
                    print_r($errors);
                }
                /******** */
                if(in_array($extension, array("png", "jpg", "gif", "jpeg", "jfif","mpg", "mpeg", "mpe", "mpv", "ogg", "mp4", "m4p", "m4v", "avi", "wmv", "mov", "qt", "flv", "swf"))) {            
                    move_uploaded_file($file_tmp, $file_path);

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
                /********* */
            } else {    
                print_r($errors);
            }
        }
    }

    header("Location: ../group.php?group=" . $_POST['group_id']);
    exit();