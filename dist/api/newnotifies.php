<?php
$homepage = true;
    include "../init.php";

    if($id != "") {

        $stat = $con->prepare("SELECT * FROM notifications WHERE taker = ? && seen = 0");
        $stat->execute(array($id));

        echo $stat->rowCount() == 0? "":"new-notifies";

    }