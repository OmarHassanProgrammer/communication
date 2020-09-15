<?php
    include "../init.php";

    if(isset($id)) {

        $stat = $con->prepare("UPDATE notifications SET seen = 1 WHERE taker = ?");
        $stat->execute(array($id));

    }