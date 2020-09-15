<?php

    if(isset($_SESSION['user'])) {

        /* My Data */ 
        $userdata = $con->prepare('SELECT * FROM users WHERE `serial` = ?');
        $userdata->execute(array($_SESSION['user']));
        $userdata = $userdata->fetch();
            /* Name */
            $name = $userdata['name'];
            /* ID */
            $id = $userdata['id'];
            /* Image */
            $my_image = $userdata['user_image'];
        /******************************/

        
    } elseif (!$homepage) {
        header("Location: index.php");
    }