<?php

    $me = $id;
    $group = $group_id;

    $stat = $con->prepare("SELECT * FROM groups_members WHERE (`user_id` = ? AND group_id = ?)");
    $stat->execute(array($me, $group));

    if($stat->rowCount() > 0) {

        $data = $stat->fetch()['rank'];
        
        $status = ($data == "request"? "request":"member");

    } else {

        $stat = $con->prepare("SELECT * FROM groups WHERE id = ?");
        $stat->execute(array($group));
        $tojoin = $stat->fetch()["tojoin"];

        $status = ($tojoin == "direct"? "no-direct":"no-request");

    }
