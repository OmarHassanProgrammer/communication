<?php
    if(isset($group_id)) {
        $stat = $con->prepare("SELECT * FROM groups_members WHERE group_id = ? AND `rank` = 'request'");
        $stat->execute(array($group_id));
        $users = $stat->fetchAll();
    }