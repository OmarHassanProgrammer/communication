<?php
    include 'init.php';

    session_unset();

    header('Location: login.php');
    exit();