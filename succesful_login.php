<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["username"])){
            echo success($_POST['username']);
        }
    }

    function success($username){
        $_SESSION['logged_in']=true;
        $_SESSION['username']=$username;
        return "sucess: ".$username;
    }
?>