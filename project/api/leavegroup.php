<?php

    include "../init.php";

    if(isset($_GET['group'])) {
        $group = $_GET['group'];

        if(isset($_GET['user_id'])) {
            $hisid = $_GET['user_id'];
        } else {
            $hisid = $id;
        }

        $stat = $con->prepare("SELECT * FROM groups_members WHERE group_id = ? AND `user_id` = ?");
        $stat->execute(array($group, $hisid));

        if($stat->rowCount() > 0) {

            $stat = $con->prepare("DELETE FROM groups_members WHERE group_id = ? AND `user_id` = ?");
            $stat->execute(array($group, $hisid));

        }

    }

    if(isset($_GET['user_id']) || isset($_GET['group'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: ../communicate.php?func=chat&type=groups");
    }