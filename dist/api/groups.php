<?php

    if($user_id != "") {

        $stat = $con->prepare("SELECT groups_members.pin, groups.*
                                FROM groups_members
                                INNER JOIN groups
                                ON groups.id = groups_members.group_id
                                WHERE (groups_members.user_id = ? 
                                        AND `rank` != 'request')");
        $stat->execute(array($user_id));
        $hisgroups = $stat->fetchAll();

    }