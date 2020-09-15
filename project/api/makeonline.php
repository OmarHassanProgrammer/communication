<?php
    include '../init.php';

    if($id != "") {
        $stat = $con->prepare("UPDATE users SET lastlogin = NOW() WHERE id = ?");
        $stat->execute(array($id));
    }