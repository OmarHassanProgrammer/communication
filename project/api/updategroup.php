<?php
    include "../init.php";

    $group_id = "";

    if(isset($_POST['id']) && isset($_POST['tojoin']) && isset($_POST['name']) && isset($_POST['description'])) {
        
        $group_id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'] != 'null'? $_POST['description'] : ' ';
        $join = $_POST['tojoin'];      

        $name = filter_var($name, FILTER_SANITIZE_STRING);
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

        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/communication/communication/dist/data/groups_logo/" . $imagename;

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

            $checkstat = $con->prepare('SELECT * FROM groups WHERE `id` = ?');
            $checkstat->execute(array($group_id));
            if ($checkstat->rowCount() == 0) {
                echo 'This group id is false';
            } else {
                $stat = $con->prepare('UPDATE groups SET `name` = ?, `description` = ?, `logo` = ?, `tojoin` = ? WHERE id = ?');
                $stat->execute(array($name, $description, 
                                            $imagename,
                                            $join,
                                            $group_id));
                $stat = $con->prepare("SELECT id FROM groups WHERE `name` = ?");
                $stat->execute(array($name));
                if($stat->rowCount() > 0) {
                    echo "the group's data is updated";
                } else {
                    echo "the group's data isn't updated";
                }
            }       

            /**************/
        } else {

            foreach($errors as $error) {

                echo "<div>" . $error . "</div>";

            }

        }
    }
header("Location: ../group.php?group=" . $group_id);
exit();