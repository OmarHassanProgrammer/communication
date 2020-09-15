<?php

    if(isset($_POST['user_id'])) {
        include "../init.php";
        $stat = $con->prepare("SELECT lastlogin as duration FROM users WHERE id = ?");
        $stat->execute(array($_POST['user_id']));
        $lastlogin = $stat->fetch();

        $duration = floor( ((time() - strtotime($lastlogin['duration'])) / 60));

        $duration_text = "";

        if($duration < 5) {
            $duration_text = "online";
        } elseif($duration < 60) {
            $duration_text = $duration . " minutes ago";
        } elseif($duration < 1440) {
            $duration_text = floor($duration / 60) . " hour(s) ago";
        } elseif($duration < 10080) {
            $duration_text = floor($duration / 1440) . " day(s) ago";
        } elseif($duration > 10080 && $duration < 11520) {
            $duration_text = "One Week ago";
        } elseif($duration < 43200) {
            $duration_text =  floor($duration / 1440) . " day(s) ago";
        } elseif($duration > 43200 && $duration < 44640) {
            $duration_text = "One Month ago";
        } elseif($duration < 518400) {
            $duration_text =  floor($duration / 43200) . " month(s) ago";
        } elseif($duration > 518400 && $duration < 519840) {
            $duration_text = "One Year ago";
        } elseif($duration > 518400) {
            $duration_text =  floor($duration / 518400) . " year(s) ago";
        }

        echo $duration_text;

    } elseif(isset($user_id)) {
        $stat = $con->prepare("SELECT lastlogin as duration FROM users WHERE id = ?");
        $stat->execute(array($user_id));
        $lastlogin = $stat->fetch();
        
        $duration = floor( ((time() - strtotime($lastlogin['duration'])) / 60));

        $duration_text = "";

        if($duration < 5) {
            $duration_text = "online";
        } elseif($duration < 60) {
            $duration_text = $duration . " minutes ago";
        } elseif($duration < 1440) {
            $duration_text = floor($duration / 60) . " hour(s) ago";
        } elseif($duration < 10080) {
            $duration_text = floor($duration / 1440) . " day(s) ago";
        } elseif($duration > 10080 && $duration < 11520) {
            $duration_text = "One Week ago";
        } elseif($duration < 43200) {
            $duration_text =  floor($duration / 1440) . " day(s) ago";
        } elseif($duration > 43200 && $duration < 44640) {
            $duration_text = "One Month ago";
        } elseif($duration < 518400) {
            $duration_text =  floor($duration / 43200) . " month(s) ago";
        } elseif($duration > 518400 && $duration < 519840) {
            $duration_text = "One Year ago";
        } elseif($duration > 518400) {
            $duration_text =  floor($duration / 518400) . " year(s) ago";
        }
    }
    