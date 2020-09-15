<?php

    if(isset($friend)) {

        $stat = $con->prepare("UPDATE messages_friend SET take_time = NOW() WHERE sender_id = ? AND taker_id = ? AND take_time = ?");
        $stat->execute(array($friend, $id, "NONE"));

    }