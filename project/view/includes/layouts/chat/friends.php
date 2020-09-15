<?php
    include "api/myfriends.php";
?>
<div class="container">
    
    <div class="search">
        <div class="content">
            <h3 class="my-title">Search</h3>
            <form class="form-search">
                <div class="form-group row">
                    <label for="id" class="col-sm-2 col-form-label">ID :</label>
                    <div class="col-sm-10">
                        <input type="text"class="form-control" id="id">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="name" class="col-sm-2 col-form-label">Name :</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name">
                    </div>
                </div>
                <div class="row user-type">
                    <div class="col-sm-6 col-md-3">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="all"  name="friendtype"/>
                            <label>All</label>
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="favourites" name="friendtype"/>
                            <label>Favourite</label>
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="blockedfirneds" name="friendtype"/>
                            <label>Blocked</label>
                        </span>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="newmessages" name="friendtype"/>
                            <label>New messages</label>
                        </span>
                    </div>
                </div>
                <div class="col-10 offset-1 col-md-4 offset-md-4">
                    <input type="submit" value="Search" class="btn btn-success btn-block">
                </div>
            </form>
        </div>
        <div class="button">
            <i class="fas fa-arrow-down"></i>
        </div>
    </div>

    <div class="friends">

    
        <div class="friend-settings new_window">
            <button class="close"><i class="far fa-times-circle"></i></button>
            <div class="content">
                <a href="" class="block-link btn btn-block"></a>
                <a href="" class="remove-link btn btn-danger btn-block">Remove Friend</a>
            </div>
        </div>

        <div class="friends-content">
            <?php
                foreach($myfriends as $index=>$user_id) {

                    if($blocks[$index] == 0) {

                        include "api/getdatafromid.php";
                        $type = "friend";
                        include 'api/newmessages.php';

                        echo '<div class="friend row" data-id="' . $user_id . '">
                                <input type="hidden" class="block-val" value="block-' . ($blocks[$index] == 1?"true":"false") . '">
                                <div class="left col-md-8">
                                    <img class="user-image" src="data/users_img/' . $user_image . '" alt="Logo">
                                    <h4 class="name">' . $user_name . '</h4>'
                                    . ($newmessages == 0? '':'<span class="badge badge-danger new-messages">' . $newmessages . '</span>') .
                                    '<span class="date">1 hour ago</span>
                                </div>
                                <div class="right col-md-4 mb-2 mb-md-0">
                                    <a href="api/togglefav.php?id=' . $user_id . '&fav=' . ($myfavourites[$index] == '1'? "true":"false") . '">
                                        <i class="fas fa-heart favourite ' . ($myfavourites[$index] == '1'? "active":"") . '"></i>
                                    </a>
                                    <button class="settings"><i class="fa fa-cog"></i></button>
                                    <a href="userprofile.php?id=' . $user_id . '"><i class="fas fa-info-circle info"></i></a>
                                </div>
                            </div> ';
                    }
                }
            ?>  
        </div>
        
    </div>

</div>