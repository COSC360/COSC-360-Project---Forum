<?php
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if(isset($_POST["username"])){
            $_SESSION['logged_in']=true;
            $_SESSION['username']=$_POST['username'];
            echo success();
        }
    }

    function success(){
        return "sucess";
    }
?>