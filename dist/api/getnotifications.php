<?php
    
    $duration_text = "";

    if($_SERVER["REQUEST_METHOD"] == "GET") {

        if($id != "") {
            
            $notifications = array();
            $links = array();
            $ids = array();
            $types = array();
            $times = array();
    
            $newnotifies = false; 

            $stat = $con->prepare("SELECT * FROM notifications WHERE taker = ?");
            $stat->execute(array($id));
            $data = $stat->fetchAll();

            foreach($data as $d) { 

                $time = $d['time']; 

                $duration = floor( ((time() - strtotime($time)) / 60));

                if($duration < 5) {
                    $duration_text = "now";
                } elseif($duration < 1440) {
                    $duration_text = date("H:i", strtotime($time));
                } elseif($duration < 518400) {
                    $duration_text = date("j F - H:i", strtotime($time));
                } elseif($duration > 518400) {
                    $duration_text = date("j F Y - H:i", strtotime($time));
                }

                array_push($notifications, $d['notification']);
                array_push($links, $d['link']);
                array_push($ids, $d['id']);
                array_push($types, $d['type']);
                array_push($times, $duration_text);

                if($d['seen'] == 0) {
                    $newnotifies = true;
                }

            }
        }
    } elseif($_SERVER["REQUEST_METHOD"] == "POST") {

        $homepage = true;
        include "../init.php";

        $stat = $con->prepare("SELECT * FROM notifications WHERE taker = ?");
        $stat->execute(array($id));
        $data = $stat->fetchAll();

        foreach($data as $d) { 

            $time = $d['time']; 

            $duration = floor( ((time() - strtotime($time)) / 60));

            if($duration < 5) {
                $duration_text = "now";
            } elseif($duration < 1440) {
                $duration_text = date("H~~i", strtotime($time));
            } elseif($duration < 518400) {
                $duration_text = date("j F - H~~i", strtotime($time));
            } elseif($duration > 518400) {
                $duration_text = date("j F Y - H~~i", strtotime($time));
            }

            echo $d['id'] . ":" . $d['notification'] . ":" . $d['link'] . ":" . $d['type'] . ":" . $duration_text .  ";";

        }

    }