<?php

    include "../init.php";

    if(isset($_GET['id']) && isset($_GET['pin'])) {

        $stat = $con->prepare("SELECT * FROM groups_members WHERE group_id = ? AND `user_id` = ?");
        $stat->execute(array($_GET['id'], $id));
        $data = $stat->fetch();

        if($stat->rowCount() > 0) {

            if($data['pin'] == 0) {
                $stat = $con->prepare("UPDATE groups_members SET pin = 1 WHERE group_id = ? AND `user_id` = ?");
                $stat->execute(array($_GET['id'], $id));
            } else {
                $stat = $con->prepare("UPDATE groups_members SET pin = 0 WHERE group_id = ? AND `user_id` = ?");
                $stat->execute(array($_GET['id'], $id));
            }
        
        }
    }

    header("Location: ../communicate.php?func=chat&type=groups");
    exit();