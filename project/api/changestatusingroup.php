<?php
    include '../init.php';
    if(isset($_GET['to']) && isset($_GET['user']) && isset($_GET['group'])) {
        $to = $_GET['to'];
        $user = $_GET['user'];
        $group = $_GET['group'];

        $me_stat = $con->prepare("SELECT * FROM groups_members WHERE `user_id` = ? AND group_id = ?");
        $me_stat->execute(array($id, $group));
        if($me_stat->rowCount() > 0) {
            $myrank = $me_stat->fetch()['rank'];

            $his_stat = $con->prepare("SELECT * FROM groups_members WHERE `user_id` = ? AND group_id = ?");
            $his_stat->execute(array($user, $group));
            if($his_stat->rowCount() > 0) {
                $hisrank = $his_stat->fetch()['rank'];

                if($myrank == "leader" || $myrank == "admin") {
                    if($hisrank == 'request') {
                        if($to == "member") {
                            $stat = $con->prepare("UPDATE groups_members SET `rank` = 'n_member' WHERE `user_id` = ? AND group_id = ?");
                            $stat->execute(array($user, $group));
                        }
                    }
                }
                if($myrank == "admin") {
                    if($hisrank == "n_member") {
                        if($to == "leader") {
                            $stat = $con->prepare("UPDATE groups_members SET `rank` = 'leader' WHERE `user_id` = ? AND group_id = ?");
                            $stat->execute(array($user, $group));
                        }
                    }
                    
                    if($hisrank == "leader") {
                        if($to == "member") {
                            $stat = $con->prepare("UPDATE groups_members SET `rank` = 'n_member' WHERE `user_id` = ? AND group_id = ?");
                            $stat->execute(array($user, $group));
                        }
                    }
                }
            }
        }
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
