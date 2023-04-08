<?php

require "database.php";

$status='';

//File upload directory
$targetDir ="images/";

//get postID
try {
    //Create connection
    $connString = DBCONN;
    $user = DBUSER;
    $pass = DBPASS;
    $pdo = new PDO($connString,$user,$pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Get results
    $sql = "SHOW TABLE STATUS LIKE 'Posts'";
    $result = $pdo->query($sql);
    $data = $result->fetch();
    $next_increment = $data['Auto_increment'];
    print_r($next_increment);
    //Close Connection
    $pdo = null;
}
catch(PDOException $e){ //Catch exception
    die($e->getMessage());
}

if(isset($_POST['submitbtn'])){
    if(!EMPTY($_FILES["image"]["name"])){
        $fileName = "postimg".$next_increment.".png";
        $targetFilePath = $targetDir.$fileName;
        $fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);

            //Upload image
            if(move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)){
            //Insert image file name into database
            try {
                //Create connection
                $connString = DBCONN;
                $user = DBUSER;
                $pass = DBPASS;
                $pdo = new PDO($connString,$user,$pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
                //Query WITH IMAGE
                $sql = "insert into Posts (usernameFK, title, postText, image, postDate, boardFK) values (?,?,?,?,?,?)";
                $pstmt = $pdo->prepare($sql);
                $pstmt -> bindValue(1,$_POST['username']);
                $pstmt -> bindValue(2,$_POST['title']);
                $pstmt -> bindValue(3,$_POST['text']);
                $pstmt -> bindValue(4,$fileName);
                $pstmt -> bindValue(5,$_POST['date']);
                $pstmt -> bindValue(6,$_POST['board']);
                print_r($sql);
                $count = $pstmt->execute();
    
                $status ="Uploaded with image";
                //Close Connection
                $pdo = null;
            }catch(PDOException $e){ //Catch exception
                die($e->getMessage());
            }

            }else{
                $status="Sorry, there was an error uploading your file.";
            }
    }else{
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Query WITHOUT IMAGE
            $sql = "insert into Posts (usernameFK, title, postText, postDate, boardFK) values (?,?,?,?,?)";
                $pstmt = $pdo->prepare($sql);
                $pstmt -> bindValue(1,$_POST['username']);
                $pstmt -> bindValue(2,$_POST['title']);
                $pstmt -> bindValue(3,$_POST['text']);
                $pstmt -> bindValue(4,$_POST['date']);
                $pstmt -> bindValue(5,$_POST['board']);
                print_r($sql);
                $count = $pstmt->execute();
    

            $status ="Uploaded without image";
            //Close Connection
            $pdo = null;
        }catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
    }
}else{
    $status = "empty";
}

//Display status message
echo $status;

finish();

function finish(){
    header("Location: home_page.php");
    exit();
}


?>