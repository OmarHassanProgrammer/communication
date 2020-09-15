<?php
    session_start();

    error_reporting(0);

    $layouts = 'includes/layouts/';
    $com = 'includes/components/';
    $libs = 'includes/libs/';

    $dsn = 'mysql:host=localhost;dbname=communication';
    $username = 'root';
    $pass = '';
    $con = new PDO($dsn, $username, $pass);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $id = '';
    $name = '';
    
    include 'data.php';