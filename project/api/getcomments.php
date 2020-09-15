<?php
    $stat = $con->prepare("SELECT comments.*,
                                    users.name,
                                    users.user_image AS `image`
                            FROM comments
                            INNER JOIN users ON users.id = comments.user_id");
    $stat->execute();

    $comments = $stat->fetchAll();