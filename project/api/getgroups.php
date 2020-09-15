<?php

    if($_SERVER["REQUEST_METHOD"] == "GET") {

        $groups_stat = $con->prepare('SELECT `id`,`logo`,`name` FROM groups');
        $groups_stat->execute();
        $groups = $groups_stat->fetchAll();

    } elseif($_SERVER["REQUEST_METHOD"] == "POST") {

        include "../init.php";

        if(isset($_POST['id']) && isset($_POST['name']) && isset($_POST['type'])) {

            $group_id_text = ($_POST['id'] == 'nono'? ' ? AND' : ' id = ? AND');
            $group_name_text = ($_POST['name'] == 'nono'? ' ?' : ' LOCATE(?, LOWER(`name`)) ');
            $group_type_text = "";

            $group_id = ($_POST['id'] == 'nono'? ' 1' : $_POST['id']);
            $group_name = ($_POST['name'] == 'nono'? ' 1' : strtolower($_POST['name']));

            $groups_stat = $con->prepare('SELECT `id`,`name`, `logo`, `tojoin` FROM groups WHERE' . $group_id_text . $group_name_text);
            $groups_stat->execute(array($group_id, $group_name));
            $groups = $groups_stat->fetchAll();

            foreach($groups as $group) {

                $group_id = $group['id'];
                $group_name = $group['name'];
                $group_logo = $group['logo'];
                include 'groupstatus.php';
                $type = $status;
                $checked = false;
                
                switch($_POST['type']) {
                    case 'all':
                        case 'nono':
                        $checked = true;
                    break;
                    case 'mygroups':
                        $checked = ($status == "member"?true:false);
                    break;
                    case 'sendingrequests':
                        $checked = ($status == "request"?true:false);
                    break;
                    case 'directjoin':
                        $checked = ($status == "no-direct"?true:false);
                    break;
                    case 'requestjoin':
                        $checked = ($status == "no-request"?true:false);
                    break;
                }
                
                if($checked) {
                    $member_stat = $con->prepare("SELECT * FROM groups_members WHERE group_id = ? and `user_id` = ? ORDER BY pin DESC");
                    $member_stat->execute(array($group_id, $id));
                    $member = $member_stat->fetch();

                    $checked_2 = true;
                    $newmessages = 0;
                    $pin = 0;
                    $type;
                    
                    if(isset($_POST['more-type'])) {
                        $checked_2 = false;

                        $pin = ($member['pin'] == 1? true:false);
                        $type = 'group';
                        $newmessages = 0;
                        include 'newmessages.php';

                        switch($_POST['more-type']) {
                            case 'all':
                            case 'nono':
                                $checked_2 = true;
                                break;
                            case 'pinedgroups':
                                $checked_2 = $pin;
                                break;
                            case 'newmessages':
                                $checked_2 = ($newmessages > 0? true:false );
                                break;
                        }
                    }
                    if($checked_2) {
                        echo $group_id . ',' . 
                                $group_name . ',' . 
                                $group_logo . ',' . 
                                ($pin == true?'true':'false') . ',' . 
                                $newmessages . ',' . 
                                $type . ';';
                    }
                }


            }
        }
    }
