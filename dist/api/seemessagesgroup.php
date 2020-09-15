<?php

    if(isset($group)) {

        $stat = $con->prepare("UPDATE see_messages_group SET take_time = NOW() WHERE group_id = ? AND `user_id` = ? AND take_time = ?");
        $stat->execute(array($group, $id, "0000-00-00 00:00:00"));

    }