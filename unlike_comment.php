<?php
    session_start();
    include "database.php";
    
    if (isset($_POST["commentID"]) && isset($_POST["number"])) {
        echo update_like($_POST["commentID"], $_SESSION['username'], $_POST["number"]);
    }

    function update_like($id, $username, $number){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Query 1
            $sql = "delete from comments_liked_by where commentIDFK=".$id." and usernameFK='".$username."'";
            $count = $pdo->exec($sql);

            //Query 2
            $sql = "update comments set likes=".$number." where commentID=".$id;
            $count = $pdo->exec($sql);

            //Close Connection
            $pdo = null;
        }catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $count;
    }

    function debug($id, $username, $other){
        return $id;
    }
?>