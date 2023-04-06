<?php
    session_start();
    require("database.php");

    if($_SERVER['REQUEST_METHOD'] != "POST") {
        header("Location: create_account.php");
    }

    try {
        $con = new PDO(DBCONN,DBUSER,DBPASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Throwable $e) {
        echo("Connection Failed ".$e->getMessage()."<br>");
    }
?>

<?php
     function variablesIsSet() {
        $vars = count($_POST);
        foreach ($_POST as $key => $value) {
            if(isset($_POST[$key])) {
               $vars -=1;
            }  
        }
        if($vars == 0) {return true;}
        else {return false;}
    }

    if (variablesIsSet()) {
        $username = $_POST["uname"];
        $firstname = $_POST["fname"];
        $lastname = $_POST["lname"];

        if($username == $_SESSION["username"]) {
            echo("No changes to the username");
        }
    }