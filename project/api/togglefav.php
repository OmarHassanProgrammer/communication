<?php

    include "../init.php";

    if(isset($_GET['id']) && isset($_GET['fav'])) {

        $stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
        $stat->execute(array($id, $_GET['id'], $id, $_GET['id']));
        $data = $stat->fetch();

        if($stat->rowCount() > 0) {

            if($data['friend1_id'] == $id) {

                if($data['friend1_fav'] == 0) {
                    $stat = $con->prepare("UPDATE friending SET friend1_fav = ? WHERE (friend1_id = ?) AND (friend2_id = ?)");
                    $stat->execute(array('1', $id, $_GET['id']));
                } else {
                    $stat = $con->prepare("UPDATE friending SET friend1_fav = ? WHERE (friend1_id = ?) AND (friend2_id = ?)");
                    $stat->execute(array('0', $id, $_GET['id']));
                }

            } elseif($data['friend2_id'] == $id) {

                if($data['friend2_fav'] == 0) {
                    $stat = $con->prepare("UPDATE friending SET friend2_fav = ? WHERE (friend2_id = ?) AND (friend1_id = ?)");
                    $stat->execute(array('1', $id, $_GET['id']));
                } else {
                    $stat = $con->prepare("UPDATE friending SET friend2_fav = ? WHERE (friend2_id = ?) AND (friend1_id = ?)");
                    $stat->execute(array('0', $id, $_GET['id']));
                }
            }
        }
    }

    header("Location: ../communicate.php?func=chat&type=friends");
    exit();