<?php

    if($_SERVER["REQUEST_METHOD"] == "GET") {

        $users_stat = $con->prepare('SELECT `id`,`name`,`email`,`user_image` FROM users');
        $users_stat->execute();
        $users = $users_stat->fetchAll();

    } elseif($_SERVER["REQUEST_METHOD"] == "POST") {

        include "../init.php";

        if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['type'])) {

            $user_id_text = ($_POST['id'] == 'nono'? ' ? AND' : ' id = ? AND');
            $user_name_text = ($_POST['name'] == 'nono'? ' ?' : ' LOCATE(?, LOWER(`name`)) ');
            $user_type_text = "";

            $user_id = ($_POST['id'] == 'nono'? ' 1' : $_POST['id']);
            $user_name = ($_POST['name'] == 'nono'? ' 1' : strtolower($_POST['name']));


            $users_stat = $con->prepare('SELECT `id`,`name`,`email`,`user_image` FROM users WHERE' . $user_id_text . $user_name_text);
            $users_stat->execute(array($user_id, $user_name));
            $users = $users_stat->fetchAll();

            foreach($users as $user) {

                $friend_id = $user['id'];
                include 'friendstatus.php';

                $type = ($status == "request"?$iam:$status);

                switch($_POST['type']) {
                    case 'all':
                    case 'nono':
                        $checked = true;
                        break;
                    case 'myfriends':
                        $checked = ($status == "friends"?true:false);
                        break;
                    case 'firndrequests':
                        $checked = ($type == "taker"?true:false);
                        break;
                    case 'sendingrequests':
                        $checked = ($type == "sender"?true:false);
                        break;
                }

                if($checked) {
                    $checked_2 = true;
                    $fav = false;
                    $blocked = false;
                    $newmessages = 0;
                    $type;

                    if(isset($_POST['more-type'])) {
                        $friending_stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? AND friend2_id = ?) OR (friend2_id = ? AND friend1_id = ?)");
                        $friending_stat->execute(array($id, $user['id'], $id, $user['id']));
                        $friending = $friending_stat->fetch();

                        if($friending['friend1_id'] == $id) {
                            $fav = ($friending['friend1_fav'] == 1? true:false);
                            $blocked = ($friending['friend1_block'] == 1? true:false);
                        } elseif ($friending['friend2_id'] == $id) {
                            $fav = ($friending['friend2_fav'] == 1? true:false);
                            $blocked = ($friending['friend2_block'] == 1? true:false);
                        }
                        $type = "friend";
                        $user_id = $friend_id;
                        $newmessages = 0;
                        include 'newmessages.php';
                        
                        switch($_POST['more-type']) {
                            case 'all':
                            case 'nono':
                                $checked_2 = true;
                                break;
                            case 'favourites':
                                $checked_2 = $fav;
                                break;
                            case 'blockedfirneds':
                                $checked_2 = $blocked;
                                break;
                            case 'newmessages':
                                $checked_2 = ($newmessages > 0? true:false );
                                break;
                        }
                    }
                    if($checked_2) {
                        echo $user['id'] . ',' . 
                                $user['name'] . ',' . 
                                $user['email'] . ',' . 
                                $user['user_image'] . ',' . 
                                ($fav == true?'true':'false') . ',' . 
                                $newmessages . ',' .
                                $type . ',' .
                                ($blocked == true?'true':'false') . ';';
                    }
                }
            }
        }
    }
