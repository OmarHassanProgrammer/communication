<?php

        if(isset($group_id)) {
    
            $stat = $con->prepare("SELECT groups_members.*, users.name AS 'user_name', users.id, users.user_image
                                    FROM groups_members
                                    INNER JOIN users
                                    ON users.id = groups_members.user_id
                                    WHERE group_id = ?
                                    AND `rank` != 'request'");
            $stat->execute(array($group_id));
            $members = $stat->fetchAll();
    
        } elseif (isset($_POST['group_id'])) {
            
            include '../init.php';
    
            $stat = $con->prepare("SELECT groups_members.*, users.name AS 'user_name', users.id, users.user_image
                                    FROM groups_members
                                    INNER JOIN users
                                    ON users.id = groups_members.user_id
                                    WHERE group_id = ?
                                    AND `rank` != 'request'");
            $stat->execute(array($_POST['group_id']));
            $members = $stat->fetchAll();
            foreach ($members as $member) {
                echo $member['user_name'] . ',' . $member['rank'] . ';';
            }
        }