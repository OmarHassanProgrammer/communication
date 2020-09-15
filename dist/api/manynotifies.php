<?php
    include_once "../init.php";

    if($id != 0) {

        $stat = $con->prepare("SELECT id FROM notifications WHERE teker = ?");
        $stat->execute(array($id));

        echo $stat->rowCount();

    }