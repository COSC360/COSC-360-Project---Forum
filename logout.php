<?php
    session_start();
    $_SESSION['logged_in']=false;
    unset($_SESSION['username']);
    header("Location: home_page.php");
    exit();
?>