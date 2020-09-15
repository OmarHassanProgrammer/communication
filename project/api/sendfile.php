<?php
    include "../init.php";
    
    if(isset($_FILES['file']) && isset($_POST['friend_id'])) {
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

                    $stat = $con->prepare("INSERT INTO messages_friend 
                                            (sender_id, taker_id, `message`, message_type)
                                            VALUES (?, ?, ?, 'image')");
                    $stat->execute(array($id, $_POST['friend_id'], $filename));

                    move_uploaded_file($file_tmp, $file_path);
                } elseif(in_array($extension, array("ogg", "mp4", "webm"))) {

                    $stat = $con->prepare("INSERT INTO messages_friend 
                                            (sender_id, taker_id, `message`, message_type)
                                            VALUES (?, ?, ?, 'video')");
                    $stat->execute(array($id, $_POST['friend_id'], $filename));

                    move_uploaded_file($file_tmp, $file_path);
                }else {
                    array_push($errors, "The File must be good file");
                    print_r($errors);
                }
                
            } else {    
                print_r($errors);
            }
        }
    }

    header("Location: ../chat.php?friend=" . $_POST['friend_id']);
    exit();