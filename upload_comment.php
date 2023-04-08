<?php
    session_start();
    date_default_timezone_set('America/Los_Angeles');
    require "database.php";

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
            $sql = "insert into Comments (usernameFK, commentText, postDate, postIDFK) values (?,?,?,?)";
            $stmt = $pdo ->prepare($sql);
            $stmt ->bindValue(1,$_POST['username']);
            $stmt ->bindValue(2,$_POST['text']);
            $stmt ->bindValue(3,$_POST['date']);
            $stmt ->bindValue(4,$_POST['postID']);
            print_r($sql);
            $count = $stmt->execute();

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