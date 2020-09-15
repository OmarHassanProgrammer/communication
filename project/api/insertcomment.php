<?php

    include "../init.php";

    if(isset($_POST['comment']) && isset($_POST['rate'])) {

        $stat = $con->prepare("SELECT * FROM comments WHERE `user_id`  = ?");
        $stat->execute(array($id));

        if($stat->rowCount() == 0) {

            $stat_insert = $con->prepare("INSERT INTO comments (comment, rate) VALUES (?, ?) WHERE `user_id` = ? ");
            $stat_insert->execute(array($_POST['comment'], $_POST['rate'], $id));   

        } else {

            $stat_update = $con->prepare("UPDATE comments SET comment = ?, rate = ? WHERE `user_id` = ? ");
            $stat_update->execute(array($_POST['comment'], $_POST['rate'], $id));

        }

    }

    header("Location: ../index.php");