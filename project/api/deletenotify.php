<?php
    include '../init.php';

    if(isset($_GET['notify_id'])) {

        $stat = $con->prepare("DELETE FROM notifications WHERE id = ?");
        $stat->execute(array($_GET['notify_id']));

    }