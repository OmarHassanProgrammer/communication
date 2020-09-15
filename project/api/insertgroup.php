<?php
    include '../init.php';

    if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['tojoin']) && isset($_POST['members'])) {
        
        $name = $_POST['name'];

        $description = $_POST['description'] != 'null'? $_POST['description'] : ' ';
        $join = $_POST['tojoin'];
        $members = explode(',', $_POST['members']);
        array_pop($members);        

        $name = filter_var($name, FILTER_SANITIZE_EMAIL);
        $description = filter_var($description, FILTER_SANITIZE_STRING);
        if(($join != "direct") && ($join != "request")) {
            $join == "direct";
        }

        //$path = "data/users_img/" . $username . '.jpg';

        //////////////////////////////////////////////////////////

        $file = $_FILES['group_logo'];
        $errors = array();

        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];

        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));

        $imagename = time() . '.' . $extension;

        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/data/groups_logo/" . $imagename;

        if($file['error'] == 4) {
            array_push($errors, "There isn't file upoloaded");
        } else {
            if($file_size > 250000) {
                array_push($errors, "The size of the file can't be bigger than 250 kb");
            }
            if(!(in_array($extension, array("png", "jpg", "gif", "jpeg", "jfif")))) {
                array_push($errors, "The File must be image");
            }
        }

        if(empty($errors)) {
            move_uploaded_file($file_tmp, $image_path);

            /**************/

            $checkstat = $con->prepare('SELECT * FROM groups WHERE `name` = ?');
            $checkstat->execute(array($name));
            if ($checkstat->rowCount() > 0) {
                echo 'this group name is exists';
            } else {
                $stat = $con->prepare('INSERT INTO groups (`name`, `description`, `logo`, `tojoin`) VALUES (?, ?, ?, ?)');
                $stat->execute(array($name, $description, 
                                            $imagename,
                                            $join));
                $stat = $con->prepare("SELECT id FROM groups WHERE `name` = ?");
                $stat->execute(array($name));
                if($stat->rowCount() > 0) {
                    $group_id = $stat->fetch()["id"];

                    $insert_stat = $con->prepare("INSERT INTO groups_members (`group_id`, `user_id`, `rank`) VALUES (?, ?, 'admin')");
                    $insert_stat->execute(array($group_id, $id));

                    foreach($members as $member) {

                        $insert_stat = $con->prepare("INSERT INTO groups_members (`group_id`, `user_id`, `rank`) VALUES (?, ?, 'n_member')");
                        $insert_stat->execute(array($group_id, $member));
                    }
                } else {
                    echo "The group wasn't inserted";
                }
            }       

            /**************/
        } else {

            foreach($errors as $error) {

                echo "<div>" . $error . "</div>";

            }

        }

        ////////////////////////////////////////////////////////////////////////////////////
        
    }

    header("Location: ../communicate.php?func=groups");
    exit();