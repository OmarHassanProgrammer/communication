<?php

    $stat = $con->prepare("SELECT * FROM comments WHERE user_id = ?");
    $stat->execute(array($id));

    if($stat->rowCount() > 0) {

        $written = true;
        $mycomment = $stat->fetch();
        $rate = $mycomment['rate'];

    } else {
        $written = false;
        $rate = 0;
    }