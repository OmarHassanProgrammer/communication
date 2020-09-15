<?php
    $type;
    if(isset($_GET['type'])) {
        $type= $_GET['type']    ;
    } else {
        $type = "friends";
    }


?>
    <div class="chat">
        <div class="chat-links">
            <a href="communicate.php?func=chat&type=friends" class="btn btn-primary chat-link <?php echo $type == "friends"? 'active':''; ?>">friends</a>
            
            <a href="communicate.php?func=chat&type=groups" class="btn btn-primary chat-link <?php echo $type == "groups"? 'active':''; ?>">groups</a>
        </div>
        
        <?php

            switch($type) {
                case "friends" :
                    include "includes/layouts/chat/friends.php";
                    break;
                case "groups" :
                    include "includes/layouts/chat/groups.php";
                    break;
            }

        ?>
    </div>
