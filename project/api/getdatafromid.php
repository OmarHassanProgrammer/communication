<?php

    if(isset($user_id)) {

        $stat = $con->prepare("SELECT * FROM users WHERE id = ?");
        $stat->execute(array($user_id));
        $data = $stat->fetch();

        $user_name = $data['name'];
        $user_email = $data['email'];
        $user_image = $data['user_image'];
        $user_desc = $data['description'];
        $user_password = $data['password'];

    }