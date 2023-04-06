<?php
    session_start();
    date_default_timezone_set('America/Los_Angeles');
    include "database.php";

    $status='empty';

    if(isset($_POST['submit'])){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Query WITHOUT IMAGE
            $sql = "insert into comments (usernameFK, commentText, postDate, postIDFK) values ('".$_POST['username']."', '".$_POST['text']."', '".$_POST['date']."', '".$_POST['postID']."')";
            print_r($sql);
            $count = $pdo->exec($sql);

            $status = "Uploaded";
            //Close Connection
            $pdo = null;
        }catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }

        //Display status message
        echo $status;
        finish();
    }
?>
<?php 
    function finish(){
        header("Location: post.php?post=".$_POST['postID']);
        exit();
    }
?>