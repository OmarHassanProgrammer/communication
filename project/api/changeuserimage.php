<?php
    include '../init.php';

    if(isset($_FILES['user_img'])) {
        $file = $_FILES['user_img'];
        $errors = array();

        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];

        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));

        $imagename = time() . '.' . $extension;

        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/communication/communication/dist/data/users_img/" . $imagename;

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

            $last_image_stat = $con->prepare("SELECT user_image FROM users WHERE id = ?");
            $last_image_stat->execute(array($id));
            $last_image = $last_image_stat->fetch()['user_image'];

            unlink($_SERVER['DOCUMENT_ROOT'] . "/data/users_img/" . $last_image);

            move_uploaded_file($file_tmp, $image_path);

            $stat = $con->prepare("UPDATE users SET user_image = ? WHERE id = ?");
            $stat->execute(array($imagename, $id));

            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();

        } else {
            
        }
    }
