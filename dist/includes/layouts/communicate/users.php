
<div class="my-container">
    <div class="users">
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
                                <input type="radio" data-value="all"  name="usertype"/>
                                <label>All</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="myfriends" name="usertype"/>
                                <label>My Friends</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="firndrequests" name="usertype"/>
                                <label>Friending Requests</label>
                            </span>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                                <input type="radio" data-value="sendingrequests" name="usertype"/>
                                <label>Sending Request</label>
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
                    <td>Name</td>
                    <td>Email</td>
                    <td>Image</td>
                    <td>Tools</td>
                </tr>
            </thead>
            <tbody>
                <?php

                include 'api/getusers.php';

                    foreach ($users as $user) {
                        echo '<tr ' . ($user['id'] == $id? 'class="active"':'') . '>';
                            echo '<td>';
                                echo $user['id'];
                            echo '</td>';
                            echo '<td>';
                                echo $user['name'];
                            echo '</td>';
                            echo '<td>';
                                echo $user['email'];
                            echo '</td>';
                            echo '<td>';
                                echo '<img class="user-img" src="data/users_img/' . $user['user_image'] . '">';
                            echo '</td>';
                            echo '<td>';

                                $friend_id = $user['id'];
                                include 'api/friendstatus.php';
                                if($user['id'] != $id) {
                                    if(($status == 'no') || (($iam == "sender") && ($status == "unfriend_1")) || (($iam == "taker") && ($status == "unfriend_2"))) {
                                        echo '<a class="btn btn-success mr-md-2 mb-1 mb-md-0" href="api/addfriend.php?friend=' . $user['id'] . '">Add friend</a>';
                                    } elseif($status == 'friends') {
                                        echo '<a class="btn btn-danger mr-md-2 mb-1 mb-md-0" href="api/changefriendstatus.php?friend=' . $user['id'] . '&status=unfriend">Remove friend</a>';
                                    } elseif($status == 'request') {

                                        if($iam == 'sender') {
                                            echo '<a class="btn btn-warning mr-md-2 mb-1 mb-md-0" href="api/removefriend.php?friend=' . $user['id'] . '">Cancel the request</a>';
                                        } elseif($iam == 'taker') {
                                            echo '<a class="btn btn-info mr-md-2 mb-1 mb-md-0" href="api/changefriendstatus.php?friend=' . $user['id'] . '&status=friends">Accept the request</a>';
                                        }

                                    } elseif((($iam == "sender") && ($status == "unfriend_2")) || (($iam == "taker") && ($status == "unfriend_1"))) {

                                        echo '<a class="btn btn-danger mr-md-2 mb-1 mb-md-0" href="api/removefriend.php?friend=' . $user['id'] . '">Your friend unfriend you</a>';

                                    }
                                }
                                echo '<a class="btn btn-primary" href="userprofile.php?id=' . $friend_id . '">Details</a>';
                            echo '</td>';
                        echo '</tr>';
                    }

                ?>
            </tbody>
        </table>
    </div>
</div>