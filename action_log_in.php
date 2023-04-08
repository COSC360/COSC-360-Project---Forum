<?php
    session_start();
    require "database.php";
?>

<?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        echo json_encode(check_credentials($_POST["username"], $_POST['password']));
    }
?>

<?php
    function check_credentials($username, $pass){
        //Connect to Database
        try {
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select * from Users where username='".$username."'";
            $result = $pdo->query($sql);

            $userData = array();
        
            $row  = $result->fetch();
            $userData = $row;
            
            //Close Connection
            $pdo = null;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $userData;
    }
?>

<?php
    function debug($username, $pass){
        return $username.$pass;
    }
?>