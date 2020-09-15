<?php

    $me = $id;
    $myfriend = $friend_id;

    $stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
    $stat->execute(array($me, $myfriend, $me, $myfriend));
    $iam = "";

    if($stat->rowCount() > 0) {

        $data = $stat->fetch();

        $status = $data['status'];
        $friend1 = $data['friend1_id'];
        $friend2 = $data['friend2_id'];

        
        if($friend1 == $me) {
            $iam = 'sender';
        } elseif($friend2 == $me) {
            $iam = 'taker';
        }



    } else {

        $status = 'no';

    }
