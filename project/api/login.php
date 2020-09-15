<?php
    $homepage = true;
    include '../init.php';

    if(isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedpass = sha1($password);

        $stat = $con->prepare('SELECT `serial` FROM `users` WHERE `username` = ? && `password` = ?');
        $stat->execute(array($username, $hashedpass));
        if($stat->rowCount() > 0) {

            echo 'you are user';

            $_SESSION['user'] = $stat->fetch()['serial'];
        } else {
            echo "error";
        }
        
    }