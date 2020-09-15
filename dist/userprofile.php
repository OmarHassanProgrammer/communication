<?php 
    include 'init.php';
    $title = 'User Profile';

    include 'includes/layouts/header.php';
?>

<?php
    $user_id = "";
    if(!isset($_GET['id'])) {
        $user_id = $id;
    } else {
        $user_id = $_GET['id'];
    }

    if($user_id == $id) {

        include "api/getdatafromid.php"; 
        ?>

            <div class="userprofile me">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 top">
                            <a href="communicate.php?func=chat" class="back">
                                <i class="fas fa-hand-point-left"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row bottom">
                        <div class="col-4 col-lg-3 left">
                            <?php
                                include "api/lastlogin.php";
                                echo '<div class="image">';
                                    echo '<img src="data/users_img/' . $user_image . '" >';
                                echo '</div>';
                                
                                echo '<h3 class="h1 name">' . $user_name . '</h3>';
                                echo '<p class="desc">' . ($user_desc == ""? "No description":$user_desc) . '</p>';

                            ?>
                        </div>
                        <div class="col-8 col-lg-9 right">
                            <?php
                                include "api/friends.php";
                                include "api/groups.php";
                            ?>
                            <div class="update">
                                <h3 class="my-title">Update :-</h3>

                                    <div class="row mx-md-2 mt-3">
                                        <div class="inputs col-lg-9">
                                            <form action="api/updateuserdata.php" method="POST">
                                                <div class="row">
                                                    <label for="name"class="col-lg-2">Name :</label>
                                                    <input  id='name' 
                                                            name='name' 
                                                            type="text" 
                                                            class="form-control col-lg-10" 
                                                            autocomplete='off'
                                                            placeholder='Change your name'
                                                            value="<?php echo $user_name; ?>">
                                                </div>
                                                <div class="row">
                                                    <label for="desc"class="col-lg-2">Description :</label>
                                                    <input  id='desc' 
                                                            name='desc' 
                                                            type="text" 
                                                            class="form-control col-lg-10" 
                                                            autocomplete='off'
                                                            placeholder='Change your description'
                                                            value="<?php echo $user_desc; ?>">
                                                </div>
                                                <div class="row">
                                                    <label for="email"class="col-lg-2">Email :</label>
                                                    <input  id='email' 
                                                            name='email' 
                                                            type="email" 
                                                            class="form-control no-rec col-lg-10" 
                                                            autocomplete='off'
                                                            value="<?php echo $user_email; ?>"
                                                            placeholder='Change your account email'>
                                                </div>
                                                <div class="row">
                                                    <label for="password"class="col-lg-2">Password :</label>
                                                    <input  id='password' 
                                                            name='password' 
                                                            type="password" 
                                                            class="form-control col-lg-10" 
                                                            autocomplete='off'
                                                            placeholder="Change your password">
                                                </div>
                                                <div class="row">
                                                    <input type="submit" value="Update" class="btn btn-outline-primary btn-block mt-2">
                                                </div>
                                            </form>
                                        </div>

                                        <div class="user-img col-lg-3">
                                            <form action="api/changeuserimage.php" enctype="multipart/form-data" method="post">
                                                <img src="data/images/unknown.jfif" alt="your Image">
                                                <div class="custom-file img-input">
                                                    <input type="file" name="user_img" class="custom-file-input update_user_image" id="user_img">
                                                    <label class="custom-file-label" for="image_file">Change the image</label>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                            </div>
                            <div class="stats">
                                <h3 class="my-title">Stats :-</h3>
                                <div class="stat text-success">
                                    <i class="fas fa-user-friends"></i>
                                    <h5>Friends</h5>
                                    <span class="stat-number" data-value="
                                                <?php echo count($hisfriends) ?>  
                                                ">0</span>
                                </div>
                                <div class="stat text-danger">
                                    <i class="fas fa-heart"></i>
                                    <h5>Favourites</h5>
                                    <span class="stat-number" data-value="
                                                    <?php   
                                                        $fav = 0;
                                                        foreach($hisfriends as $index=>$friend) {
                                                            if($myfavourites[$index] == 1) {
                                                                $fav += 1;
                                                            }
                                                        }
                                                        echo $fav;
                                                    ?>
                                            ">0</span>   
                                </div>
                                <div class="stat text-secondary">
                                    <i class="fas fa-users"></i>
                                    <h5>Groups</h5>
                                    <span class="stat-number" data-value="
                                                <?php echo count($hisgroups) ?>  
                                            ">0</span>
                                </div>
                                <div class="stat text-info">
                                    <i class="fas fa-envelope"></i>
                                    <h5>Send Messages</h5>
                                    <span class="stat-number" data-value="
                                                    <?php
                                                        $new_messages_stat = $con->prepare("SELECT messages_friend.*, users.name
                                                                                            FROM messages_friend
                                                                                            INNER JOIN users 
                                                                                            ON users.id = messages_friend.sender_id
                                                                                            where sender_id = ?");
                                                        $new_messages_stat->execute(array($user_id));
                                                        $new_messages = $new_messages_stat->fetchAll();
                                                        $num_messages = $new_messages_stat->rowCount();
                                                        
                                                        $new_messages_stat = $con->prepare("SELECT messages_group.message_id
                                                                                            FROM messages_group
                                                                                            INNER JOIN users 
                                                                                            ON users.id = messages_group.sender_id
                                                                                            where sender_id = ?");
                                                        $new_messages_stat->execute(array($user_id));
                                                        $new_messages += $new_messages_stat->fetchAll();
                                                        $num_messages += $new_messages_stat->rowCount();

                                                        echo $num_messages;
                                                    ?>
                                            ">0</span>   
                                </div>
                            </div>
                            <div class="friends">
                                <h3 class="my-title">Friends :-</h3>
                                <?php
                                    if(count($hisfriends) == 0) {
                                        echo '<div class="alert alert-warning text-center font-weight-bold mt-3">He doesn\'t has any friend</div>';
                                    } else {
                                        foreach($hisfriends as $friend) {
                                            $user_id = $friend;
                                            include "api/getdatafromid.php";
                                            
                                            echo '<div class="friend">';
                                                echo '<a href="userprofile.php?id=' . $user_id . '">';
                                                    echo '<img src="data/users_img/' . $user_image . '" class="image" />';
                                                    echo '<h5 class="name">' . $user_name . '</h5>';
                                                echo '</a>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <div class="groups">
                                <h3 class="my-title">Groups :-</h3>
                                <?php
                                    if(count($hisgroups) == 0) {
                                        echo '<div class="alert alert-warning text-center font-weight-bold mt-3">He isn\'t Join to any group</div>';
                                    } else {
                                        foreach($hisgroups as $group) {
                                            $group_id = $group['id'];
                                            include "api/groupdata.php";

                                            echo '<div class="group">';
                                                echo '<a href="group.php?group=' . $group_id . '&t=details">';
                                                    echo '<img src="data/groups_logo/' . $thegroup['logo'] . '" class="image" />';
                                                    echo '<h5 class="name">' . $thegroup['name'] . '</h5>';
                                                echo '</a>';
                                            echo '</div>';
                                        }
                                    }
                                ?>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php

    } else {
        include "api/getdatafromid.php"; 
        ?>

            <div class="userprofile">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 top">
                            <a href="communicate.php?func=chat" class="back">
                                <i class="fas fa-hand-point-left"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row bottom">
                        <div class="col-5 col-lg-3 left">
                            <?php
                                include "api/lastlogin.php";
                                echo '<div class="image">';
                                    echo '<img src="data/users_img/' . $user_image . '" >';
                                    if($duration_text == "online") {
                                        echo '<span class="online"></span>';
                                    }
                                echo '</div>';
                                
                                echo '<h3 class="h1 name">' . $user_name . '</h3>';
                                echo '<p class="desc">' . ($user_desc == ""? "No description":$user_desc) . '</p>';

                                $friend_id = $user_id;
                                include 'api/friendstatus.php';
                                if($user_id != $id) {
                                    if(($status == 'no') || (($iam == "sender") && ($status == "unfriend_1")) || (($iam == "taker") && ($status == "unfriend_2"))) {
                                        echo '<a href="api/addfriend.php?friend=' . $user_id . '" class="btn btn-tool btn-success btn-add">Add Friend</a>';
                                    } elseif($status == 'friends') {
                                        echo '<a class="btn btn-tool btn-add btn-primary mr-2 mb-3" href="chat.php?friend=' . $user_id . '">Chat him</a>';
                                        echo '<a class="btn btn-tool btn-remove btn-danger mr-2" href="api/changefriendstatus.php?friend=' . $user_id . '&status=unfriend">Remove friend</a>';
                                    } elseif($status == 'request') {

                                        if($iam == 'sender') {
                                            echo '<a class="btn btn-tool btn-remove btn-warning text-light font-weight-bold mr-2" href="api/removefriend.php?friend=' . $user_id . '">Cancel the request</a>';
                                        } elseif($iam == 'taker') {
                                            echo '<a class="btn btn-tool btn-add btn-info mr-2" href="api/changefriendstatus.php?friend=' . $user_id . '&status=friends">Accept the request</a>';
                                        }

                                    } elseif((($iam == "sender") && ($status == "unfriend_2")) || (($iam == "taker") && ($status == "unfriend_1"))) {

                                        echo '<a class="btn btn-tool btn-add btn-danger mr-2" href="api/removefriend.php?friend=' . $user_id . '">Your friend unfriend you</a>';

                                    }
                                }
                            ?>
                        </div>
                        <div class="col-7 col-lg-9 right">
                            <?php
                                include "api/friends.php";
                                include "api/groups.php";
                            ?>
                            <div class="stats">
                                <h3 class="my-title">Stats :-</h3>
                                <div class="stat text-success">
                                    <i class="fas fa-user-friends"></i>
                                    <h5>Friends</h5>
                                    <span class="stat-number" data-value="
                                                <?php echo count($hisfriends) ?>  
                                                ">0</span>
                                </div>
                                <div class="stat text-danger">
                                    <i class="fas fa-heart"></i>
                                    <h5>Favourites</h5>
                                    <span class="stat-number" data-value="
                                                    <?php   
                                                        $fav = 0;
                                                        foreach($hisfriends as $index=>$friend) {
                                                            if($myfavourites[$index] == 1) {
                                                                $fav += 1;
                                                            }
                                                        }
                                                        echo $fav;
                                                    ?>
                                            ">0</span>   
                                </div>
                                <div class="stat text-secondary">
                                    <i class="fas fa-users"></i>
                                    <h5>Groups</h5>
                                    <span class="stat-number" data-value="
                                                <?php echo count($hisgroups) ?>  
                                            ">0</span>
                                </div>
                                <div class="stat text-info">
                                    <i class="fas fa-envelope"></i>
                                    <h5>Send Messages</h5>
                                    <span class="stat-number" data-value="
                                                    <?php
                                                        $new_messages_stat = $con->prepare("SELECT messages_friend.*, users.name
                                                                                            FROM messages_friend
                                                                                            INNER JOIN users 
                                                                                            ON users.id = messages_friend.sender_id
                                                                                            where sender_id = ?");
                                                        $new_messages_stat->execute(array($user_id));
                                                        $new_messages = $new_messages_stat->fetchAll();
                                                        $num_messages = $new_messages_stat->rowCount();
                                                        
                                                        $new_messages_stat = $con->prepare("SELECT messages_group.message_id
                                                                                            FROM messages_group
                                                                                            INNER JOIN users 
                                                                                            ON users.id = messages_group.sender_id
                                                                                            where sender_id = ?");
                                                        $new_messages_stat->execute(array($user_id));
                                                        $new_messages += $new_messages_stat->fetchAll();
                                                        $num_messages += $new_messages_stat->rowCount();

                                                        echo $num_messages;
                                                    ?>
                                            ">0</span>   
                                </div>
                            </div>
                            <div class="friends">
                                <h3 class="my-title">Friends :-</h3>
                                <?php
                                    if(count($hisfriends) == 0) {
                                        echo '<div class="alert alert-warning text-center font-weight-bold mt-3">He doesn\'t has any friend</div>';
                                    } else {
                                        foreach($hisfriends as $friend) {
                                            $user_id = $friend;
                                            include "api/getdatafromid.php";
                                            
                                            echo '<div class="friend">';
                                                echo '<a href="userprofile.php?id=' . $user_id . '">';
                                                    echo '<img src="data/users_img/' . $user_image . '" class="image" />';
                                                    echo '<h5 class="name">' . $user_name . '</h5>';
                                                echo '</a>';
                                            echo '</div>';
                                        }
                                    }
                                ?>
                            </div>
                            <div class="groups">
                                <h3 class="my-title">Groups :-</h3>
                                <?php
                                    if(count($hisgroups) == 0) {
                                        echo '<div class="alert alert-warning text-center font-weight-bold mt-3">He isn\'t Join to any group</div>';
                                    } else {
                                        foreach($hisgroups as $group) {
                                            $group_id = $group['id'];
                                            include "api/groupdata.php";

                                            echo '<div class="group">';
                                                echo '<a href="group.php?group=' . $group_id . '&t=details">';
                                                    echo '<img src="data/groups_logo/' . $thegroup['logo'] . '" class="image" />';
                                                    echo '<h5 class="name">' . $thegroup['name'] . '</h5>';
                                                echo '</a>';
                                            echo '</div>';
                                        }
                                    }
                                ?>                            
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php
    }



?>

<?php

    include 'includes/layouts/footer.php';