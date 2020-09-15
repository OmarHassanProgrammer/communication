<?php
    if(isset($user_id)) {
        $stat = $con->prepare("SELECT friending.*
                                FROM friending
                                WHERE (friend1_id = ? OR friend2_id = ?) AND `status` = 'friends'");
        $stat->execute(array($user_id, $user_id));
        $hisfriends = array();

        if($stat->rowCount() > 0) {
            $friends = $stat->fetchAll();
            $myfavourites = array();

            foreach($friends as $friend) {
                if($friend['friend2_id'] == $user_id) {
                    array_push($hisfriends, $friend['friend1_id']);
                    array_push($myfavourites, $friend['friend2_fav']);

                } elseif($friend['friend1_id'] == $user_id) {
                    array_push($hisfriends, $friend['friend2_id']);
                    array_push($myfavourites, $friend['friend1_fav']);
                }
            }
        }
    }