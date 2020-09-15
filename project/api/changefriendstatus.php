<?php
    include "../init.php";

    if(isset($_GET['friend']) && isset($_GET['status'])) {

        $me = $id;

        $myfriend = $_GET['friend'];

        $status = $_GET['status'];

        $myfriend_stat = $con->prepare("SELECT `id` FROM users WHERE `id` = ?");
        $myfriend_stat->execute(array($myfriend));

        if($myfriend_stat->rowCount() > 0) {
            
            $stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
            $stat->execute(array($me, $myfriend, $me, $myfriend));
            $data = $stat->fetch();

            switch($status) {

                case "friends":
                    if($data['friend2_id'] == $me) {
                        $update = $con->prepare("UPDATE friending SET `status` = 'friends'  WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
                        $update->execute(array($me, $myfriend, $me, $myfriend));

                        $notify_stat = $con->prepare("INSERT INTO notifications (taker, `notification`, link, `type`) VALUES (?, ?, ?, 'friend_request_accepted') ");
                        $notify_stat->execute(array($myfriend, $name . " accept your friendship request", 'communicate.php?func=chat'));
                    }
                    break;
                case "unfriend":
                    if($data['friend1_id'] == $me) {
                        $update = $con->prepare("UPDATE friending SET `status` = 'unfriend_1'  WHERE (friend1_id = ? AND friend2_id = ?)");
                        $update->execute(array($me, $myfriend));

                    } elseif($data['friend2_id'] == $me) {
                        $update = $con->prepare("UPDATE friending SET `status` = 'unfriend_2' WHERE (friend2_id = ? AND friend1_id = ?)");
                        $update->execute(array($me, $myfriend));
                    }
                    break;

            }

    }
}

header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();