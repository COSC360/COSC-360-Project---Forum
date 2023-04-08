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
    define("ROLE","user");
    define("DEFAULT_PIC","images/profile.svg");

    if (variablesIsSet()) {
        $user = $_POST["uname"];
        $firstName = $_POST["fname"];
        $lastName = $_POST["lname"];
        $email = $_POST["email"];
        $pass = md5($_POST["pword"]);
        $bday = $_POST["bdayYear"]."-".$_POST["bdayMonth"]."-".$_POST["bdayDate"];
        $joinDate = date("Y-m-d H:i:sa");
        $pic = $_POST["uploadPic"];
        

        
        $sql = "INSERT INTO Users (username, firstName, lastName, email, password, birthdate, role, dateJoined) VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $con->prepare($sql);
        $stmt -> bindParam(1,$user);
        $stmt -> bindParam(2,$firstName);
        $stmt -> bindParam(3,$lastName);
        $stmt -> bindParam(4,$email);
        $stmt -> bindParam(5,$pass);
        $stmt -> bindParam(6,$bday);
        $stmt -> bindValue(7,ROLE);
        $stmt -> bindValue(8,$joinDate);
        $result = $stmt ->execute();

        if($result){
           
            $_SESSION["username"] = $user;
            $_SESSION["logged_in"] = true;
            if($pic != DEFAULT_PIC) {
                $sql = "UPDATE Users SET profilePic = ? WHERE username =".$_SESSION["username"];
                $stmt = $con->prepare($sql);
                $stmt -> bindParam(1,$pic);
                $stmt -> execute();
            }
            header("Location: home_page.php");
            $con = null;
        } 

        

    }

?>