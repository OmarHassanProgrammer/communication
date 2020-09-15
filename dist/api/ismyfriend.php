<?php

    $me = $id;
    $myfriend = $friend_id;

    $stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
    $stat->execute(array($me, $myfriend, $me, $myfriend));

    $myfriend = $stat->rowCount() > 0? 'yes' : 'no';
