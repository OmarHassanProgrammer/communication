<?php
$homepage = true;
    $title = 'Log In';
    include 'init.php';

    include $layouts . 'header.php';

    if(isset($_SESSION['user'])) {
        header('Location: communicate.php');
        exit();
    }

?>

<form class='login-form' action="api/login.php" method="post">
    <h2 class="title">Log In</h2>
    <input  id='username' 
        name='username' 
        type="text" 
        class="form-control" 
        autocomplete='off'
        placeholder='User Name'
        required>
    <input  id='password' 
            name='password' 
            type="password" 
            class="form-control" 
            autocomplete='off'
            placeholder='Password'
            required>
    <input  type="submit" 
            value="Log In"
            class='btn btn-primary btn-block'>
    <a href="signup.php">Create new account | </a>
    <a href="index.php"> Home</a>

</form>

<?php

    include $layouts . 'footer.php';