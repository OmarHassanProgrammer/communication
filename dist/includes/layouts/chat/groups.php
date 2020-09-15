<?php
    include "api/mygroups.php";
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
                    <div class="col-sm-4">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="all"  name="grouptype"/>
                            <label>All</label>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="pinedgroups" name="grouptype"/>
                            <label>Pined Groups</label>
                        </span>
                    </div>
                    <div class="col-sm-4">
                        <span class="radio-custom style-gold theme-5 my-0 my-md-1">
                            <input type="radio" data-value="newmessages" name="grouptype"/>
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

    <div class="groups">

        <?php
            foreach($mygroups as $index=>$group) {

                $group_id = $group['id'];
                $type = "group";
                include 'api/newmessages.php';

                echo '<div class="group row" data-id="' . $group["id"] . '">
                        <div class="left col-md-8">
                            <img class="group-logo" src="data/groups_logo/' . $group['logo'] . '" alt="Logo">
                            <h4 class="name">' . $group["name"] . '</h4>'
                            .  ($newmessages == 0? '':'<span class="badge badge-danger new-messages ml-2">' . $newmessages . '</span>') . '
                        </div>
                        <div class="right col-md-4 mb-2 mb-md-0"> 
                            <a href="api/togglepin.php?id=' . $group["id"] . '&pin=' . ($group["pin"] == '1'? "true":"false") . '">
                                <i class="fas fa-thumbtack pin ' . ($group["pin"] == '1'? "active":"") . '"></i>
                            </a>
                            <a href="group.php?group=' . $group_id . '&t=details"><i class="fas fa-info-circle info"></i></a>

                        </div>
                    </div> ';
            }
        ?>  
    </div>

</div>