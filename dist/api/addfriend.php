<?php
    include '../init.php';

    if(isset($_GET['friend'])) {

        $me = $id;

        $myfriend = $_GET['friend'];

        $myfriend_stat = $con->prepare("SELECT `id` FROM users WHERE `id` = ?");
        $myfriend_stat->execute(array($myfriend));
        

        if($myfriend_stat->rowCount() > 0) {

            $friending_stat = $con->prepare("SELECT * FROM friending  WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
            $friending_stat->execute(array($me, $myfriend, $me, $myfriend));

            if($friending_stat->rowCount() > 0) {

                $data = $friending_stat->fetch();
                if(($data['status'] == "unfriend_1") or ($data['status'] == "unfriend_2")) {

                    $stat = $con->prepare("UPDATE friending SET `status` = 'request', friend1_id = ?, friend2_id = ? WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
                    $stat->execute(array($me, $myfriend, $me, $myfriend, $me, $myfriend));
                    
                    $notify_stat = $con->prepare("INSERT INTO notifications (taker, `notification`, link, `type`) VALUES (?, ?, ?, 'friend_request') ");
                    $notify_stat->execute(array($myfriend, $name . " sent a friendship request to you", 'communicate.php?func=users'));
    
                }

            } else {

                $stat = $con->prepare("INSERT INTO friending (friend1_id, friend2_id, `status`) VALUES (?, ?, 'request')");
                $stat->execute(array($me, $myfriend));
                    
                $notify_stat = $con->prepare("INSERT INTO notifications (taker, `notification`, link, `type`) VALUES (?, ?, ?, 'friend_request') ");
                $notify_stat->execute(array($myfriend, $name . " sent a friendship request to you", 'communicate.php?func=users'));

            }
            

        }

header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
        
    }