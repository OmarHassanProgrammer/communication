<?php
$homepage = true;
    include '../init.php';

    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
        
        $name = $_POST['name'];
        $email = $_POST['email'] != 'null'? $_POST['email'] : ' ';
        $username = $_POST['username'];
        $password = $_POST['password'];
        

        $name = filter_var($name, FILTER_SANITIZE_STRING);
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
        $username = filter_var($username, FILTER_SANITIZE_STRING);
        $password = filter_var($password, FILTER_SANITIZE_STRING);

        $hashedpass = sha1($password);
        $serial = uniqid();

        //$path = "data/users_img/" . $username . '.jpg';

        //////////////////////////////////////////////////////////

        $file = $_FILES['user_img'];
        $errors = array();

        $file_name = $file['name'];
        $file_type = $file['type'];
        $file_size = $file['size'];
        $file_tmp = $file['tmp_name'];

        $extension = explode('.', $file_name);
        $extension = strtolower(end($extension));

        $imagename = time() . '.' . $extension;

        $image_path = $_SERVER['DOCUMENT_ROOT'] . "/data/users_img/" . $imagename;

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

            $checkstat = $con->prepare('SELECT id FROM users WHERE username = ?');
            $checkstat->execute(array($username));
            if ($checkstat->rowCount() > 0) {
                echo 'this user name is exists';
            } else {
                $stat = $con->prepare('INSERT INTO users (`name`, `email`, `user_image`, `username`, `password`, `serial`) VALUES (?, ?, ?, ?, ?, ?)');
                $stat->execute(array($name, $email, 
                                            $imagename,
                                            $username, $hashedpass, $serial));
                if($stat->rowCount() > 0) {

                    $_SESSION['user'] = $serial;


                } else {
                    echo "You aren't user";
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

    header("Location: ../communicate.php");
    exit();