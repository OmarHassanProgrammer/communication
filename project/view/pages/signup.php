<?php
$homepage = true;
    $title = 'Sign Up';
    include 'init.php';

    include $layouts . 'header.php';
    
    if(isset($_SESSION['user'])) {
        header('Location: communicate.php');
        exit();
    }

?>

<form class='signup-form' action="api/signup.php" method="post" enctype="multipart/form-data">
    <h2 class="title">Sign Up</h2>

    <div class="row">
        <div class="inputs col-12 col-xl-9">
            <div class="row">
                <label for="name"class="col-sm-4 col-lg-2">User Name :</label>
                <input  id='name' 
                        name='name' 
                        type="text" 
                        class="form-control col-sm-8 col-lg-10" 
                        autocomplete='off'
                        placeholder='Your full name'
                        required>
            </div>
            <div class="row">
                <label for="email"class="col-sm-4 col-lg-2">Email :</label>
                <div class="col-sm-8 col-lg-10">
                    <input  id='email' 
                            name='email' 
                            type="email" 
                            class="form-control" 
                            autocomplete='off'
                            placeholder='Write a correct email'>
                </div>
                
            </div>
            <div class="row">
                <label for="username"class="col-sm-4 col-lg-2">User Name :</label>
                <input  id='username' 
                        name='username' 
                        type="text" 
                        class="form-control col-sm-8 col-lg-10" 
                        autocomplete='off'
                        placeholder="You will use it to log in"
                        required>
            </div>
            <div class="row">
                <label for="password"class="col-sm-4 col-lg-2">Password :</label>
                <input  id='password' 
                        name='password' 
                        type="password" 
                        class="form-control col-sm-8 col-lg-10" 
                        autocomplete='off'
                        placeholder="The password must be hard"
                        required>
            </div>
        </div>

        <div class="user-img col-12 col-xl-3">

            <img src="data/images/unknown.jfif" alt="your Image">
            <div class="custom-file">
                <input type="file" name="user_img" class="custom-file-input" id="user_img">
                <label class="custom-file-label" for="image_file">Choose image</label>
            </div>

        </div>
    </div>
    
    
    <div class="row">
        <input type="submit" class="btn btn-success btn-block" value="Sign Up" name="submit">
        <a href="login.php">I have an account |  </a>  
        <a href="index.php">  Home</a>
    </div>
</form>

<?php

    include $layouts . 'footer.php';