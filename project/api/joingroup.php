<?php
    include "../init.php";

    if(isset($_GET['group'])) {
        $group = $_GET['group'];

        $stat = $con->prepare("SELECT * FROM groups WHERE id = ?");
        $stat->execute(array($group));

        if($stat->rowCount() > 0) {

            $tojoin = $stat->fetch()["tojoin"];

            if($tojoin == "direct") {

                $insert_stat = $con->prepare("INSERT INTO groups_members (group_id, `user_id`, `rank`) VALUES (?, ?, 'n_member')");
                $insert_stat->execute(array($group, $id));

            } elseif ($tojoin == "request") {

                $insert_stat = $con->prepare("INSERT INTO groups_members (group_id, `user_id`, `rank`) VALUES (?, ?, 'request')");
                $insert_stat->execute(array($group, $id));

            }

        }

    }

    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();