<?php
    $title = "Chat";

    include "init.php";
    include "includes/layouts/header.php";

?>

<div class="chat_friend container-fluid">

    <div class="viewer new_window">
        <button class="close"><i class="far fa-times-circle"></i></button>  
        <div class="content">
        </div>
    </div>
    <div class="top row"> 
        
        <div class="myfriends col-lg-3 d-none d-lg-inline-block">

            <div class="head row">
                <a href="communicate.php?func=chat&type=friends" class="back-btn col-1">
                    <i class="fa fa-arrow-left"></i>
                </a>
                <div class="title col-11">
                    <h3>Friends</h3>
                </div>
            </div>

            <div class="body friends">
                <?php
                    
                    include "api/myfriends.php";

                    foreach($myfriends as $index=>$user_id) {

                        include "api/getdatafromid.php";
                        $type = "friend";
                        include 'api/newmessages.php';

                        echo '<div class="friend ' . ($user_id == $_GET['friend']? "active":"") . '" data-id="' . $user_id . '">
                                <div class="left">
                                    <img class="user-img" src="data/users_img/' . $user_image . '">
                                    <h4 class="name">' . $user_name . '</h4>'
                                    . ($user_id == $_GET['friend']?"":($newmessages == 0? '':'<span class="badge badge-danger new-messages">' . $newmessages . '</span>')) .
                                    '<span class="date">1 hour ago</span>
                                </div>
                            </div> ';
                    }
                ?>  
            </div>
            
        </div>

        <div class="d-none">
            <?php 
                    $user_id = $_GET['friend'];
                    include "api/getdatafromid.php";

                        echo "<div class='his-image'>" . $user_image . "</div>";

                    $user_id = $id;
                    include "api/getdatafromid.php";

                        echo "<div class='my-image'>" . $user_image . "</div>";

                ?>
        </div>

        <div class="right col-lg-9">
            <div class="header my-friend w-100 d-inline-block d-lg-none" data-id="<?php echo $_GET['friend']; ?>">
                <a href="communicate.php?func=chat"><i class="fas fa-arrow-up back"></i></a>
                <?php
                    $user_id = $_GET['friend'];
                    include "api/getdatafromid.php";

                    echo '<img class="user-img" src="data/users_img/' . $user_image . '">';                    
                    echo '<div class="data">';
                        echo '<h2 class="name">' . $user_name . '</h2>';
                        echo '<span class="date"></span>';
                    echo '</div>';
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
            <form action="api/sendfile.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="friend_id" value="<?php echo $_GET['friend']; ?>">
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
                $emojis = array("😘","😙","😚","😇","😉","😊","🙃","🤣","😂","😅","😀","😁","😃","😄","😆","😕","☹️","🙁",
                                "😒","😏","🤩","😎","🤓","🧐","😕","😋","😛","😜","😝","😍","😳","🤯","😤","😡","😠","🤬",
                                "😢","😭","😩","😧","😖","😞","😔","😟","😮","😬","😑","😐","😶","🤥","🤫","🤭","🤔","🤨",
                                "🤗","😥","😨","😰","😱","🤒","😷","🤕","🤧","🤢","😵","🤐","😪","😴","🤤","😦","😧","😲",
                                "😦","😧","🙄","🙄","😸","😹","😻","😼","😽","🙀","😿","😾","👾","👽","🤖","👻","💀","☠",
                                "🤡","💩","👹","👺","😈","👿","🤠","🤑","🤲","👐","🙌","👏","🤝","👍","👎","👊","✊","🤛",
                                "🤜","🤞","✌️","🤟","🤘","👌","👈","👉","👆","👇","☝️","✋","🤚","🖐","🖖","👋","🤙","💪","🙏",
                                "💋","👄","👀","👁","👅","👂","👃","🧠");
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

    include "includes/layouts/footer.php";