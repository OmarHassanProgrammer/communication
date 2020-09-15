<?php
    $title = "Group Details";

    include "init.php";
    include "includes/layouts/header.php";

?>

<?php
    if(isset($_GET['t'])) {
        if($_GET['t'] == "details") {
?>

<?php
    $group_id = "";
    if(!isset($_GET['group'])) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $group_id = $_GET['group'];
    }

    include "api/groupdata.php"; 
    ?>

        <div class="groupdetails">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 top">
                        <a href="communicate.php?func=chat" class="back">
                            <i class="fas fa-hand-point-left"></i>
                        </a>
                    </div>
                </div>
                <div class="row bottom">
                    <div class="col-6 col-lg-3 left">
                        <?php
                            echo '<div class="image">';
                                echo '<img src="data/groups_logo/' . $thegroup['logo'] . '" >';
                            echo '</div>';
                            
                            echo '<h3 class="h1 name">' . $thegroup['name'] . '</h3>';
                            echo '<p class="desc">' . ($thegroup['description'] == ""? "No description":$thegroup['description']) . '</p>';

                            include 'api/groupstatus.php';
                            
                            echo '<div class="buttons">';
                                if($status == "no-direct") {
                                    echo '<a class="px-2" href="api/joingroup.php?group=' . $group_id . '"><i class="fas fa-plus join text-success px-1"></i></a>';
                                } elseif ($status == "no-request") {
                                    echo '<a class="" href="api/joingroup.php?group=' . $group_id . '"><i class="fas fa-envelope text-warning"></i></a>';
                                } elseif ($status == "request") {
                                    echo '<a class="" href="api/leavegroup.php?group=' . $group_id . '">
                                                <span class="fa-stack cover-parent">
                                                    <i class="fas fa-envelope fa-stack-1x text-warning covered"></i>
                                                    <i class="fas fa-ban fa-stack-2x text-danger cover"></i>
                                                </span>
                                            </a>';
                                } elseif ($status == "member") {
                                    echo '<a class="display-block" href="group.php?group=' . $group_id . '"><i class="fas fa-door-open text-secondary"></i></a></br>';
                                    echo '<a class="" href="api/leavegroup.php?group=' . $group_id . '"><i class="fas fa-sign-out-alt text-danger ml-5 mt-1"></i></a>';
                                }
                            echo '</div>';
                            
                        ?>
                    </div>
                    <div class="col-6 col-lg-9 right">
                        <?php
                            $group_id = $_GET["group"];
                            include "api/usersingroup.php";
                        ?>
                        <div class="stats">
                            <h3 class="my-title">Stats :-</h3>
                            <div class="stat text-success">
                                <i class="fas fa-users"></i>
                                <h5>Members</h5>
                                <span class="stat-number" data-value="
                                            <?php echo count($members); ?>  
                                            ">0</span>
                            </div>
                            <div class="stat text-danger">
                                <i class="fas fa-thumbtack"></i>
                                <h5>pins</h5>
                                <span class="stat-number" data-value="
                                                <?php 
                                                    $pin_count = 0;
                                                    foreach($members as $member) {
                                                        if($member['pin'] == 1)
                                                            $pin_count += 1;
                                                    }
                                                    echo $pin_count;
                                                ?>
                                        ">0</span>
                            </div>
                            <div class="stat text-info">
                                <i class="fas fa-envelope"></i>
                                <h5>Messages</h5>
                                <span class="stat-number" data-value="
                                                <?php   
                                                    $stat = $con->prepare("SELECT * FROM messages_group WHERE group_id = ?");
                                                    $stat->execute(array($group_id));
                                                    echo count($stat->fetchAll());
                                                ?>
                                        ">0</span>   
                            </div>
                        </div>

                        <div class="users">
                            <h3 class="my-title">Users :-</h3>
                            <?php

                                foreach($members as $member) {

                                    echo '<div class="user">';
                                        echo '<a href="userprofile.php?id=' . $member['id'] . '">';
                                            echo '<img src="data/users_img/' . $member['user_image'] . '" class="image" />';
                                            echo '<h5 class="name">' . $member['user_name'] . '</h5>';
                                        echo '</a>';
                                    echo '</div>';

                                }

                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php

include 'includes/layouts/footer.php';

}
} else {
    ?>

<div class="chat_group container-fluid">
    
    <?php
            $group_id = $_GET['group'];
            include "api/groupdata.php";
            include "api/usersingroup.php";
            ?>

        <div class="messages_seens new_window">
            <button class="close"><i class="far fa-times-circle"></i></button>  
            <div class="content">

            </div>
        </div>

        <div class="viewer new_window">
            <button class="close"><i class="far fa-times-circle"></i></button>  
            <div class="content">
            </div>
        </div>

        <div class="group-settings new_window">
            <button class="close"><i class="far fa-times-circle"></i></button>  

            <?php
                echo '<div class="header container-fluid">';
                    echo '<div class="w-100 settings-top">';
                    
                        echo '<form class="row" action="api/updategroup.php" method="post" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="id" value="' . $_GET['group'] . '">';
                            echo '<input type="hidden" id="tojoin" name="tojoin" value="' . ($thegroup['tojoin'] == "direct"? "direct":"request") . '">';
                            echo '<div class="img col-md-6">';
                                echo '<img class="group_logo" src="data/groups_logo/' . $thegroup['logo'] . '" alt="' . $thegroup['name'] . '">';
                                echo '<div class="cover"></div>';
                                echo '<div class="change-logo">';
                                    echo '<i class="far fa-images"></i>';
                                    echo '<input type="file" name="group_logo"/>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="data col-md-6">';
                                echo '<div class="name">';
                                    //echo '<h3 class="">' . $thegroup['name'] . '</h3>';
                                    echo '<input class="form-control" name="name" type="text" value="' . $thegroup['name'] . '" />';
                                echo '</div>';
                                echo '<div class="description pt-2">';
                                    //echo '<p class="">' . $thegroup['description'] . '</p>';
                                    echo '<textarea class="form-control" name="description">' . $thegroup['description'] . '</textarea>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="join-type col-12">';
                                echo '<div class="row">';
                                    echo '  <div class="col-md-4">
                                                <span class="radio-custom theme-3 style-1">
                                                    <input type="radio" data-value="direct"  name="join" ' . ($thegroup['tojoin'] == "direct"? "checked":"") . '/>
                                                    <label>Any one can join</label>
                                                </span>
                                            </div>
                                            <div class="col-md-4 offset-md-2">
                                                <span class="radio-custom theme-3 style-1">
                                                    <input type="radio" data-value="request"  name="join" ' . ($thegroup['tojoin'] == "request"? "checked":"") . '/>
                                                    <label>Send a request first</label>
                                                </span>
                                            </div>';
                                echo '</div>';
                            echo '</div>';
                            echo '<div class="col-8 offset-2">';
                                echo '<input type="submit" class="btn btn-primary btn-block" value="Update" />';
                            echo '</div>';
                        echo '</form>';
                    echo '</div>';
                echo '</div>';

                echo '<div class="members">';   
                    echo '<h2 class="my-title">Members</h2>';
                    foreach($members as $member) {
                        echo '<div class="member">';
                            echo '<img class="image" src="data/users_img/' . $member['user_image'] . '">';
                            echo '<h4 class="name">' . $member['user_name'] . '</h4>';
                            if($member['rank'] == "n_member") {
                                echo '<span class="rank badge text-light badge-warning">Member</span>';
                                echo '<div class="tools">';
                                    include "api/groupstatus.php";
                                    if($data == "admin") {
                                        echo '<a href="api/changestatusingroup.php?group=' . $_GET['group'] . '&user=' . $member['id'] . '&to=leader"><i class="fas fa-level-up-alt text-success"></i></a>';
                                    }
                                    echo '<a href="api/leavegroup.php?user_id=' . $member['id'] . '&group=' . $_GET['group'] . '"><i class="fas fa-user-times kick text-danger"></i></a>';
                                echo '</div>';
                            } elseif($member['rank'] == "leader") {
                                echo '<span class="rank badge text-light badge-info">Leader</span>';
                                include "api/groupstatus.php";
                                if($data == "admin") {
                                    echo '<div class="tools">';
                                        echo '<a href="api/changestatusingroup.php?group=' . $_GET['group'] . '&user=' . $member['id'] . '&to=member"><i class="fas fa-level-down-alt text-warning"></i></a>';
                                        echo '<a href="api/leavegroup.php?user_id=' . $member['id'] . '&group=' . $_GET['group'] . '"><i class="fas fa-user-times kick text-danger"></i></a>';
                                    echo '</div>';
                                }
                            } else {
                                echo '<span class="rank badge text-light badge-success">Admin</span>';
                            }
                        echo '</div>';
                    }
                echo '</div>';

                if($thegroup['tojoin'] == "request") {
                    echo '<div class="requests">';
                        echo '<h2 class="my-title">Requsets</h2>';

                        $group_id = $_GET['group'];
                        include "api/getrequestsingroup.php";

                        if(count($users) == 0) {
                            echo ' <div class="user alert alert-info font-weight-bold text-center pb-2">There is no requests</div>';

                        } else {
                            foreach($users as $user) {
                                $group_id = $user['group_id'];
                                $user_id = $user['user_id'];
                                include "api/getdatafromid.php";
                                echo '<div class="user">';
                                    echo '<img class="image" src="data/users_img/' . $user_image . '">';
                                    echo '<h4 class="name">' . $user_name . '</h4>';
                                    echo '<div class="tools mt-2 mt-md-0">';
                                        echo '<a href="api/changestatusingroup.php?group=' . $_GET['group'] . '&user=' . $user_id . '&to=member"><i class="fas fa-vote-yea text-success"></i></a>';
                                        echo '<a href="api/leavegroup.php?user_id=' . $user_id . '&group=' . $_GET['group'] . '"><i class="fas fa-times-circle text-danger"></i></a>';
                                    echo '</div>';
                                echo '</div>';

                            }
                        }
                    echo '</div>';
                }
            ?>
        </div>

        <div class="top row"> 
            
            <div class="groups col-3 col-lg-3 d-none d-lg-inline-block">

                <div class="head row">
                    <a href="communicate.php?func=chat&type=groups" class="back-btn col-1">
                        <i class="fa fa-arrow-left"></i>
                    </a>
                    <div class="title col-11">
                        <h3>Groups</h3>
                    </div>
                </div>

                <div class="body friends">
                    <?php
                        
                        include "api/mygroups.php";

                        foreach($mygroups as $index=>$group) {

                            $group_id = $group["id"];
                            $type = "group";
                            include 'api/newmessages.php';

                            echo '<div class="group ' . ($group_id == $_GET['group']? "active":"") . '" data-id="' . $group_id . '">
                                    <div class="left">
                                        <img class="group-logo" src="data/groups_logo/' . $group["logo"] . '">
                                        <h4 class="name">' . $group['name'] . '</h4>'
                                        . //($group_id == $_GET['group']?"":($newmessages == 0? '':'<span class="badge badge-danger new-messages">' . $newmessages . '</span>')) .
                                    '</div>
                                </div> ';
                        }
                    ?>  
                </div>
                
            </div>

            <div class="d-none users_image">
                <?php 
                        $group_id = $_GET['group'];
                        include "api/usersingroup.php";

                        foreach($members as $member) {

                            $user_id = $member["user_id"];
                            include "api/getdatafromid.php";
                            if($user_name == $name) {
                                echo "<div class='my-image'>" . $user_image . "</div>";
                            } else {
                                echo "<div class='" . str_replace(" ", "_", $user_name) . "'>" . $user_image . "</div>";
                            }


                        }

                    ?>
            </div>

            <div class="right col-lg-9">
                <div class="header">
                    <a href="communicate.php?func=chat"><i class="fas fa-arrow-up back"></i></a>
                    <?php

                        echo '<img src="data/groups_logo/' . $thegroup['logo'] . '" alt="' . $thegroup['name'] . '">';
                        echo '<div class="data">';
                            echo '<h2 class="name">' . $thegroup['name'] . '</h2>';
                            echo '<div class="members">';
                                foreach($members as $member) {
                                    echo '<span class="member ' . ($member['rank'] == "admin"?"active":"") . '">' . $member['user_name'] . '</span>';
                                }
                            echo '</div>';
                        echo '</div>';

                        echo '<div class="tools">';
                            include "api/groupstatus.php";
                            if($data == "admin") {
                                echo '<a href="api/removegroup.php?group=' . $_GET['group'] . '" class="btn text-danger removegroup"> <i class="fas fa-trash-alt"></i> </a>';
                            }
                            
                            echo '<a href="api/leavegroup.php?group=' . $_GET['group'] . '" class="btn"> <i class="fas fa-sign-out-alt text-danger"></i> </a>';

                            if($data == "admin" || $data == "leader") {
                                echo '<button class="btn text-warning group-setting-btn"> <i class="fa fa-cogs"></i> </button>';
                            }
                            echo '<a href="group.php?group=' . $_GET['group'] . '&t=details" class="btn"><i class="fas fa-info-circle info"></i></a>';

                        echo '</div>'
                    ?>
                </div>

                <div class="messages">
                    
                </div>
            </div>

        </div>
        <div class="bottom">
        <div class="make-message">    
            <form action="api/insertmessage.php" method="post">
                <input type="hidden" name="friend_id" value="<?php echo $_GET['friend']; ?>">
                <div class="send">
                    <input type="submit" value="" class="btn send-btn">
                    <span class="send-img">
                        <i class="fa fa-paper-plane"></i>
                    </span>
                </div>
            </form>
            <form action="api/sendfilegroup.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="group_id" value="<?php echo $_GET['group']; ?>">
                <div class="send-file">
                    <div class="custom-file send-file-btn">
                            <input type="file" class="custom-file-input file" name="file" id="file">
                    </div>
                    <span class="send-file-img">
                        <i class="fa fa-file-alt"></i>
                    </span>
                </div>
            </form>
                <!--<input type="text" class="message-field form-control">-->
                <textarea name="message" cols="100" rows="2" class="message-field form-control" autofocus></textarea>
        </div>

            <div class="emojis d-none d-lg-inline-block">            
                <?php
                    $emojis = array("😘","😙","😚","😇","😉","😊","🙃","🤣","😂","😅","😀","😁","😃","😄","😆","😕","☹️","🙁","😒","😏","🤩","😎","🤓","🧐","😕","😋","😛","😜",
                                    "😝","😍","😳","🤯","😤","😡","😠","🤬","😢","😭","😩","😧","😖","😞","😔","😟","😮","😬","😑","😐","😶","🤥","🤫","🤭","🤔","🤨","🤗","😥",
                                    "😨","😰","😱","🤒","😷","🤕","🤧","🤢","😵","🤐","😪","😴","🤤","😦","😧","😲","😦","😧","🙄","🙄","😸","😹","😻","😼","😽","🙀","😿","😾",
                                    "👾","👽","🤖","👻","💀","☠","🤡","💩","👹","👺","😈","👿","🤠","🤑","🤲","👐","🙌","👏","🤝","👍","👎","👊","✊","🤛","🤜","🤞","✌️","🤟","🤘","👌",
                                    "👈","👉","👆","👇","☝️","✋","🤚","🖐","🖖","👋","🤙","💪","🙏","💋","👄","👀","👁","👅","👂","👃","🧠");
                    foreach($emojis as $emoji) {
                        echo '<span class="emoji">';
                            echo $emoji;
                        echo '</span>';
                    }

                ?>
            </div>
        </div>

    </div>

<?php
    }

    include "includes/layouts/footer.php";