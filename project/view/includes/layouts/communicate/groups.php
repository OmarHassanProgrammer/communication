

<div class="my-container">
    <div class="groups">
        <!--<div class="search">
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
                        <div class="col-3">
                            <span class="radio-custom style-gold theme-5">
                                <input type="radio" data-value="all"  name="usertype"/>
                                <label>All</label>
                            </span>
                        </div>
                        <div class="col-3">
                            <span class="radio-custom style-gold theme-5">
                                <input type="radio" data-value="myfriends" name="usertype"/>
                                <label>My Friends</label>
                            </span>
                        </div>
                        <div class="col-3">
                            <span class="radio-custom style-gold theme-5">
                                <input type="radio" data-value="firndrequests" name="usertype"/>
                                <label>Friending Requests</label>
                            </span>
                        </div>
                        <div class="col-3">
                            <span class="radio-custom style-gold theme-5">
                                <input type="radio" data-value="sendingrequests" name="usertype"/>
                                <label>Sending Request</label>
                            </span>
                        </div>
                    </div>
                    <div class="col-4 offset-4">
                        <input type="submit" value="Search" class="btn btn-success btn-block">
                    </div>
                </form>
            </div>
            <div class="button">
                <i class="fas fa-arrow-down"></i>
            </div>
        </div>-->

        <button class="btn btn-primary new-group-button" style="position:relative;top:58px;">New Group</button>

        <div class="new-group new_window">
            <div class="new-group-content">
                <button class="close"><i class="far fa-times-circle"></i></button>
                <h3 class="my-title">Insert Group:-</h3>
                <form action="api/insertgroup.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="members" id="membersingroup">
                    <input type="hidden" name="tojoin" id="tojoin">
                    <div class="row">
                        <div class="inputs col-xl-9">
                            <div class="row">
                                <label for="name"class="col-lg-2">Group Name :</label>
                                <input  id='name' 
                                        name='name' 
                                        type="text" 
                                        class="form-control col-lg-10" 
                                        autocomplete='off'
                                        placeholder="The group's name"
                                        required>
                            </div>
                            <div class="row">
                                <label for="description"class="col-lg-2">Description :</label>
                                <div class="col-lg-10">
                                    <input  id='description' 
                                            name='description' 
                                            type="text" 
                                            class="form-control" 
                                            autocomplete='off'
                                            placeholder='The description of the group'>
                                </div>
                            </div>
                            <div class="row join-type">
                                <div class="col-lg-4">
                                    <span class="radio-custom theme-3 style-1">
                                        <input type="radio" data-value="direct"  name="join"/>
                                        <label>Any one can join</label>
                                    </span>
                                </div>
                                <div class="col-lg-4 offset-lg-2">
                                    <span class="radio-custom theme-3 style-1">
                                        <input type="radio" data-value="request"  name="join"/>
                                        <label>Send a request first</label>
                                    </span>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-lg-2">Members :</label>
                                <div class="members col-lg-10">
                                    <div class="added-members form-control">
                                    </div>
                                    <button class="btn btn-success add-member btn-block">Add Members</button>
                                </div>
                            </div>
                        </div>
                        <div class="group-logo col-xl-3">

                            <img src="data/images/unknown.jfif" alt="The logo of the group">
                            <div class="custom-file">
                                <input type="file" name="group_logo" class="custom-file-input" id="group_logo">
                                <label class="custom-file-label" for="image_file">Choose image</label>
                            </div>

                        </div>
                        
                        <input type="submit" value="Insert" class="btn btn-primary btn-block insert-button">
                        
                    </div>
                </form>
            </div>

            <div class="myfriends">
                <button class="close"><i class="far fa-times-circle"></i></button>
                <?php
                    include "api/myfriends.php";
                    foreach($myfriends as $index=>$user_id) {

                        include "api/getdatafromid.php";
        
                        echo '<div class="myfriend" data-id="' . $user_id . '" data-name="' . $user_name . '" data-image="' . $user_image . '">
                                <img class="user-image" src="data/users_img/' . $user_image . '" alt="Logo">
                                <h4 class="name">' . $user_name . '</h4>
                            </div> ';
                    }
                ?>
            </div>
        </div>

        <div class="search">
            <div class="content">
                <h3 class="my-title">Search</h3>
                <form class="form-search">
                    <div class="form-group row">
                        <label for="search_id" class="col-sm-2 col-form-label">ID :</label>
                        <div class="col-sm-10">
                            <input type="text"class="form-control id" id="search_id">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="search_name" class="col-sm-2 col-form-label">Name :</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control name" id="search_name">
                        </div>
                    </div>
                    <div class="row user-type">
                        <div class="col-sm-6 col-md-4">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="all"  name="grouptype"/>
                                <label>All</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="mygroups" name="grouptype"/>
                                <label>My Groups</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="directjoin" name="grouptype"/>
                                <label>Direct join</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="requestjoin" name="grouptype"/>
                                <label>Request join</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-4">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="sendingrequests" name="grouptype"/>
                                <label>Sending Requsets</label>
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

        <table class="table table-info table-striped table-responsive">
            <thead>
                <tr class='bg-info'>
                    <td>ID</td>
                    <td>Logo</td>
                    <td>Name</td>
                    <td>members</td>
                    <td>Tools</td>
                </tr>
            </thead>
            <tbody>
                <?php

                include 'api/getgroups.php';

                    foreach ($groups as $group) {
                        echo '<tr>';
                            echo '<td>';
                                echo $group['id'];
                            echo '</td>';
                            echo '<td>';
                                echo '<img class="group-logo" src="data/groups_logo/' . $group['logo'] . '">';
                            echo '</td>';
                            echo '<td>';
                                echo $group['name'];
                            echo '</td>';
                            
                            echo '<td>';
                                $group_id = $group["id"];
                                include "api/usersingroup.php";

                                foreach($members as $member) {

                                    echo "<span class='member " . $member['rank'] . " " . ($member["user_name"] == $name?"me":"")  . "' title='" . ($member['rank'] == "n_member"? "member":$member['rank']) . "'>" . ($member["user_name"] == $name?"me":$member["user_name"]) . "</span>";

                                }

                            echo '</td>';
                            echo '<td>';
                            
                                include 'api/groupstatus.php';
                                
                                if($status == "no-direct") {
                                    echo '<a class="btn mr-md-2 mb-1 mb-md-0 btn-success" href="api/joingroup.php?group=' . $group_id . '">Join to group</a>';
                                } elseif ($status == "no-request") {
                                    echo '<a class="btn mr-md-2 mb-1 mb-md-0 btn-info" href="api/joingroup.php?group=' . $group_id . '">Send a request</a>';
                                } elseif ($status == "request") {
                                    echo '<a class="btn mr-md-2 mb-1 mb-md-0 btn-warning" href="api/leavegroup.php?group=' . $group_id . '">Cancel the request</a>';
                                } elseif ($status == "member") {
                                    echo '<a class="btn mr-md-2 mb-1 mb-md-0 btn-danger" href="api/leavegroup.php?group=' . $group_id . '">Leave group</a>';
                                }                                
                                echo '<a class="btn btn-primary" href="group.php?group=' . $group_id . '&t=details">Details</a>';

                            echo '</td>';
                        echo '</tr>';
                    }

                ?>
            </tbody>
        </table>
    </div>
</div>