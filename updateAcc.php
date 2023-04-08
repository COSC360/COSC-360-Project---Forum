<?php
    session_start();
    require("database.php");

    if($_SERVER['REQUEST_METHOD'] != "POST") {
        header("Location: account.php");
    }

    try {
        $con = new PDO(DBCONN,DBUSER,DBPASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Throwable $e) {
        echo("Connection Failed ".$e->getMessage()."<br>");
    }

    $sql = "SELECT username, firstName, lastName, email, birthdate, profilePic FROM Users WHERE username='".$_SESSION["username"]."'";
    $stmt  = $con -> query($sql);
    $result = $stmt-> fetch(PDO::FETCH_ASSOC);
?>

    <body>
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
        $bday = $_POST["bday"];
        $email = $_POST["email"];

    
    
        if($username != $_SESSION["username"]) {
            $prep = "UPDATE Users SET username= ? WHERE username = ?";
            $pstmt = $con->prepare($prep);

            $pstmt -> bindValue(1,$username,PDO::PARAM_STR);
            $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
            $pstmt ->execute();
            $_SESSION["username"] = $username;
        }

        if ($firstname != $result["firstName"]) {
            $prep = "UPDATE Users SET firstName= ? WHERE username = ?";
            $pstmt = $con->prepare($prep);

            $pstmt -> bindValue(1,$firstname,PDO::PARAM_STR);
            $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
            $pstmt ->execute();
        }

        if ($lastname != $result["lastName"]) {
            $prep = "UPDATE Users SET lastName= ? WHERE username = ?";
            $pstmt = $con->prepare($prep);

            $pstmt -> bindValue(1,$lastname,PDO::PARAM_STR);
            $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
            $pstmt ->execute();
        }

        if ($bday != $result["birthdate"]) {
            $prep = "UPDATE Users SET birthDate= ? WHERE username = ?";
            $pstmt = $con->prepare($prep);

            $pstmt -> bindValue(1,$bday);
            $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
            $pstmt ->execute();
        }

        if ($email != $result["email"]) {
            $prep = "UPDATE Users SET email= ? WHERE username = ?";
            $pstmt = $con->prepare($prep);

            $pstmt -> bindValue(1,$email,PDO::PARAM_STR);
            $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
            $pstmt ->execute();
        }

        if ($pic != $result["profilePic"]) {
            include("profilePic.php");
            $pic = $filePath;
        }

        header("Location: account.php");
    }
?>