<nav class="navbar main-navbar navbar-expand-sm navbar-dark bg-info">
    <a class="navbar-brand" href="../dist/">Communication</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-contentt" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbar-contentt">
        <ul class="navbar-nav mr-auto nav-left">
            <li class="nav-item ml-2 ml-md-0">
                <a class="nav-link <?php echo $linkactive == 'users'? 'active':''; ?>" href="?func=users">users</a>
            </li>
            <li class="nav-item ml-2 ml-md-0">
                <a class="nav-link <?php echo $linkactive == 'chat'? 'active':''; ?>" href="?func=chat">chat</a>
            </li>
            <li class="nav-item ml-2 ml-md-0">
                <a class="nav-link <?php echo $linkactive == 'groups'? 'active':''; ?>" href="?func=groups">groups</a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto nav-right">
            <li class="nav-item">
                <img class="user-image" src="data/users_img/<?php echo $my_image; ?>" alt="My Logo">
            </li>
            <li class="nav-item">
                <a class="nav-link user-name" href="userprofile.php"><?php echo $name; ?></a>
            </li>
            <li class="nav-item dropdown">
                <div class="notification">
                    
                    <?php
                        include "api/getnotifications.php";
                    ?>

                    <a class="nav-link dropdown-toggle notify-btn <?php echo ($newnotifies == true? "new-notifies":"") ?>" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell notify-icon"></i>
                    </a>
                    <div class="dropdown-menu notifies" aria-labelledby="navbarDropdown">
                        <?php                                                
                            

                            if(count($notifications) == 0) {

                                echo "<div class='font-weight-bold text-center text-light'>There's not any notifications</div>";

                            }

                            foreach($notifications as $index=>$notification) {

                                echo '
                                    <a class="dropdown-item notify" href="' . $links[$index] . '">
                                        <span class="sr-only id">' . $ids[$index] . '</span>';

                                if($types[$index] == 'friend_request') {
                                    echo '<i class="fas fa-user-friends"></i>';
                                } elseif($types[$index] == 'friend_request_accepted') {
                                    echo '<i class="fas fa-user-check"></i>';
                                } elseif($types[$index] == 'message') {
                                    echo '<i class="fas fa-envelope"></i>';
                                }

                                echo $notification . 
                                    '<span class="date">' . $times[$index] . '</span>' .
                                '</a>';

                            }

                        ?>
                    </div>

                </div>
            </li>
            <li class="nav-item logout-item">
                <a class="nav-link btn btn-danger logout" href="logout.php">Log Out</a>
            </li>
        </ul>
    </div>
</nav>