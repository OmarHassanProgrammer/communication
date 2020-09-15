<?php

    if(isset($_SESSION['user'])) {

        $stat = $con->prepare("SELECT * FROM friending WHERE (friend1_id = ? OR friend2_id = ?) AND `status` = 'friends'");
        $stat->execute(array($id, $id));
        $data = $stat->fetchAll();

        $myfriends = array();
        $myfavourites = array();
        $images = array();
        $blocks = array();
        
        foreach($data as $d) {

            if($d['friend1_id'] == $id) {

                array_push($myfriends, $d['friend2_id']);
                array_push($myfavourites, $d['friend1_fav']);
                array_push($blocks, $d['friend1_block']);

            } else {

                array_push($myfriends, $d['friend1_id']);
                array_push($myfavourites, $d['friend2_fav']);
                array_push($blocks, $d['friend2_block']);

            }
        }

    }