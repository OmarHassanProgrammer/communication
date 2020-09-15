<?php
    include "../init.php";

    if(isset($_GET['group'])) {
        $group_id = $_GET['group'];

        $group_stat = $con->prepare("SELECT * FROM groups WHERE id = ?");
        $group_stat->execute(array($group_id));

        if($group_stat->rowCount() > 0) {
            $admin_stat = $con->prepare("SELECT * FROM groups_members WHERE group_id = ? AND `user_id` = ?");
            $admin_stat->execute(array($group_id, $id));
            
            if($admin_stat->rowCount() > 0) {
                $isAdmin = ($admin_stat->fetch()['rank'] == "admin"?true:false);

                if($isAdmin) {
                    $stat = $con->prepare("DELETE FROM groups WHERE id = ?");
                    $stat->execute(array($group_id));
                }
            }
        }
    }
    header("Location: ../communicate.php?func=chat&type=groups");
    exit();