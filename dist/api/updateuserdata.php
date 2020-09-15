<?php
    include '../init.php';

    $data_stat = $con->prepare("SELECT * FROM users WHERE id = ?");
    $data_stat->execute(array($id));
    $data = $data_stat->fetch();

    $name = $data['name'];
    $desc = $data["description"];
    $email = $data["email"];
    $password = "";

    if(isset($_POST['name'])) {
        if($_POST['name'] != "") {
            $name = $_POST['name'];    
        }
    }
    if(isset($_POST['desc'])) {
        if($_POST['desc'] != "") {
            $desc = $_POST['desc'];
        }
    }
    if(isset($_POST['email'])) {
        if($_POST['email'] != "") {
            $email = $_POST['email'];
        }
    }
    if(isset($_POST['password'])) {
        if($_POST['password'] != "") {
            $password = sha1($_POST['password']);
        }
    }

    $stat = $con->prepare("UPDATE users SET `name` = ?, `description` = ?, `email` = ?" . ($password != ""?", `password`":"") . " = ? WHERE id = ?");
    $stat->execute(array($name, $desc, $email, $password, $id));

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();