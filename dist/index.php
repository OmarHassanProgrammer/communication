<?php
$homepage = true;
    $title = 'Communication';
    include 'init.php';

    include $layouts . 'header.php';

?>

    <div class='home-page-header container-fluid'>
        <div class="row">
            <div class="nav-title col-3">
                <h1>Communication</h1>
            </div>
            <div class="nav-buttons col-7 offset-2 col-md-5 offset-md-4">
                <div class="btn-group w-100">
                    <?php if(!isset($_SESSION['user'])) {
                        echo '<a class="log-in btn" href="login.php">Log in</a>';
                        echo '<a class="sign-up btn" href="signup.php">Sign up</a>';
                    } else {
                        echo '<a class="btn btn-secondary communicate" href="communicate.php">Communicate</a>';
                        echo '<a class="btn btn-primary logout" href="logout.php">Log out</a>';
                    } ?>
                </div>
            </div>
            <!---------------------------------------->
            <div class="title col-12">
                <h1>Communication</h1>
            </div>
            <div class="buttons col-10 offset-1 col-md-8 offset-md-2">
                <div class="btn-group w-100">
                    <?php if(!isset($_SESSION['user'])) {
                        echo '<a class="log-in btn" href="login.php">Log in</a>';
                        echo '<a class="sign-up btn" href="signup.php">Sign up</a>';
                    } else {
                        echo '<a class="btn btn-secondary communicate" href="communicate.php">Communicate</a>';
                        echo '<a class="btn btn-primary logout" href="logout.php">Log out</a>';
                    } ?>
                </div>
            </div>
            <span class="scroll">
                <i class="fas fa-chevron-down"></i>
                <i class="fas fa-chevron-down"></i>
                <i class="fas fa-chevron-down"></i>
            </span>
        </div>
    </div>

    <div class="home-page-body pt-3">
        <div class="container-fluid">
            <div class="row">
                
                <div class="what col-md-6">
                    <h2 class="my-title">What's it?</h2>
                    <p class="content">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consectetur dolorum nostrum magni neque optio asperiores. Voluptas neque cupiditate et amet optio temporibus in veritatis minus est, similique a maiores sint quas hic ullam sequi excepturi laborum commodi, accusamus architecto. Quo vero delectus quisquam nihil molestiae voluptates iure sunt magni nisi accusamus quod harum aut unde animi qui neque consectetur architecto recusandae, dolore, libero nulla. Inventore nostrum maxime iure beatae quo sunt repellendus repellat veniam excepturi fugiat iusto porro, voluptate dignissimos eius odit qui, ab commodi. Architecto nemo deserunt aliquid accusamus ipsam aut sequi commodi ullam nisi asperiores? Tempore, debitis facere.
                    </p>
                </div>
                <div class="about col-md-6">
                    <h2 class="my-title">About us</h2>
                    <p class="content">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Beatae ex, itaque sapiente, amet ut ipsam veniam temporibus praesentium maxime facilis earum ab asperiores rem quasi totam labore eaque inventore nesciunt molestias omnis impedit placeat voluptate veritatis. Sint quam, adipisci repudiandae dolorem autem quos maiores labore laboriosam necessitatibus numquam rem distinctio suscipit possimus. Assumenda dicta, illo non explicabo, earum iusto corporis repellat optio recusandae accusamus dolorum distinctio sapiente excepturi ipsam iste dolore sit. Dolorem fuga, aut iure laboriosam, nostrum facere doloribus saepe eveniet ratione maiores alias esse asperiores officia! Quasi molestias id autem minima harum ratione velit corporis atque natus numquam!
                    </p>
                </div>
                <div class="features col-sm-12">
                    <h2 class="my-title">Features</h2>
                    <div class="content row">

                        <div class="col-md-6 col-xl-3">
                            <div class="feature responsive">
                                <div class="left"></div>
                                <div class="icon">
                                    <i class="fa fa-mobile"></i>
                                </div>
                                <p class="content">Responsive in all screens</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="feature browsers">
                                <div class="left"></div>
                                <div class="icon">
                                    <i class="fab fa-internet-explorer"></i>
                                </div>
                                <p class="content">friendly with all browsers</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="feature cleancode">
                                <div class="left"></div>
                                <div class="icon">
                                    <i class="fas fa-code"></i>
                                </div>
                                <p class="content">Clean code</p>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-3">
                            <div class="feature goodcode">
                                <div class="left"></div>
                                <div class="icon">
                                    <i class="fab fa-html5"></i>
                                </div>
                                <p class="content">Good HTML code</p>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="comments col-sm-12">
                    <h2 class="my-title">Comments</h2>

                    <div class="content">

                        <?php
                            include "api/getcomments.php";

                            foreach($comments as $comment) {

                                echo '<div class="comment ' . ($comment['user_id'] == $id? 'active':'') . '">

                                    <div class="image"><img src="data/users_img/' . $comment['image'] . '" alt="' . $comment['name'] . '"></div>
                                    <h3 class="name">' . $comment['name'] . '</h3>
                                    <div class="rate">
                                        <i class="fas fa-star star ' . ($comment['rate'] >= 1? 'active':'') . '"></i>
                                        <i class="fas fa-star star ' . ($comment['rate'] >= 2? 'active':'') . '"></i>
                                        <i class="fas fa-star star ' . ($comment['rate'] >= 3? 'active':'') . '"></i>
                                        <i class="fas fa-star star ' . ($comment['rate'] >= 4? 'active':'') . '"></i>
                                        <i class="fas fa-star star ' . ($comment['rate'] == 5? 'active':'') . '"></i>
                                    </div>
                                    <div class="text">
                                    ' . $comment['comment'] . '
                                    </div>

                                </div>';

                            }
                        
                        ?>
                    </div>
                </div>

                <div class="mycomment col-sm-12">
                    <h2 class="my-title">My comment</h2>
                    <div class="content">
                            <form action="api/insertcomment.php" method="post">

                                <?php

                                    include 'api/writtencomment.php';
                                    
                                    if($id != "") {
                                        echo '<textarea name="comment" id="" cols="30" rows="10">' . ($written == true? $mycomment['comment']:'') . '</textarea>
                                                <div class="rate">
                                                    <span class="star" data-num="1"><i class="fas fa-star ' . ($rate >= 1? 'active':'') . '"></i></span>
                                                    <span class="star" data-num="2"><i class="fas fa-star ' . ($rate >= 2? 'active':'') . '"></i></span>
                                                    <span class="star" data-num="3"><i class="fas fa-star ' . ($rate >= 3? 'active':'') . '"></i></span>
                                                    <span class="star" data-num="4"><i class="fas fa-star ' . ($rate >= 4? 'active':'') . '"></i></span>
                                                    <span class="star" data-num="5"><i class="fas fa-star ' . ($rate >= 5? 'active':'') . '"></i></span>   
                                                    <input type="hidden" name="rate" id="rate" value="' . ($written == true? $rate:'') . '">
                                                </div>
                                                
                                                <input type="submit" value="Send comment" class="btn btn-primary">
                                            ';
                                    } else {

                                        echo '<div class="alert alert-primary row">
                                                    <div class="text col-12 col-md-8">
                                                        You are not a user please log in or sign up
                                                    </div>

                                                    <div class="buttons col-12 col-md-4 mt-2 mt-md-0">
                                                        <a class="log-in btn" href="login.php">Log in</a>
                                                        <a class="sign-up btn" href="signup.php">Sign up</a>
                                                    </div>
                                            </div> ';

                                    }

                                ?>
                            </form>
                    </div>
                </div>

                <div class="footer col-12">  
                    <div class="rights col-12">
                            All rights reserved for Omar Hassan Elfatairy <span class="text-success">Communication</span> &copy;
                    </div>
                    <div class="data row">
                        <div class="left col-12 col-md-8 mb-2 mb-md-0">
                            <span class="phone">
                                <i class="fas fa-mobile-alt"></i> &nbsp; 01001058192
                            </span>
                            <span class="email">
                                <i class="fas fa-at"></i> &nbsp;omar13102005@gmail.com
                            </span>
                        </div>
                        
                        <div class="right col-12 col-md-4 mt-2 mt-md-0">
                            <a class="facebook d-md-block" href="https://www.facebook.com/profile.php?id=100012040758354" target="_blank"><i class="fab fa-facebook-f"></i> &nbsp; Facebook</a>
                            <a class="youtube d-md-block" href="https://www.youtube.com/channel/UCYNCltz97kntjwULxQ6T0vg" target="_blank"><i class="fab fa-youtube"></i> &nbsp;Youtube</a>
                            <a class="instagram d-md-block" href="https://www.instagram.com/omarhassan716/?igshid=6idd9yox6z0" target="_blank"><i class="fab fa-instagram"></i> &nbsp; Instagram</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

<?php

    include $layouts . 'footer.php';