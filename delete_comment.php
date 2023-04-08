<?php
session_start();
require "database.php";

if (isset($_POST["id"])) {
    delete_comment($_POST["id"]);
}

function delete_comment($id){
    try {
        //Create connection
        $connString = DBCONN;
        $user = DBUSER;
        $pass = DBPASS;
        $pdo = new PDO($connString,$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Query 1
        $sql = "delete from comments where commentID=".$id;
        $count = $pdo->exec($sql);

        //Close Connection
        $pdo = null;
    }catch(PDOException $e){ //Catch exception
        die($e->getMessage());
    }
}


?>