<?php
    if(isset($group_id)) {
        $stat = $con->prepare("SELECT * FROM groups WHERE id = ?");
        $stat->execute(array($group_id));
        $thegroup = $stat->fetch();
    }