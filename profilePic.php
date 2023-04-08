<?php
session_start();
include("database.php");

function getNextIncrement() {
    $next_increment;
    try {
        //Create connection
        $connString = DBCONN;
        $user = DBUSER;
        $pass = DBPASS;
        $pdo = new PDO($connString,$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Get results
        $sql = "SHOW TABLE STATUS LIKE 'Users'";
        $result = $pdo->query($sql);
        $data = $result->fetch();
        $next_increment = $data['Auto_increment'];
        //Close Connection
        $pdo = null;
    }
    catch(PDOException $e){ //Catch exception
        die($e->getMessage());
    }
    return $next_increment;
}

try {
    $con = new PDO(DBCONN,DBUSER,DBPASS);
    $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\Throwable $e) {
    echo("Connection Failed ".$e->getMessage()."<br>");
}

if(isset($_SESSION["username"])) {
    // For an existing account
    $sql = "SELECT userID FROM Users WHERE username=?";
    $stmt = $con -> prepare($sql);
    $stmt ->bindValue(1, $_SESSION["username"],PDO::PARAM_STR);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);
    $userID = $result["userID"];

    //Upload file to directory (For an existing account)
    $targetDir ="images/";
    $filename = "profilepic_user".$userID.".png";
    $filePath = $targetDir.$filename;
    $imageFileType = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
    $uploadOk = 1;

    if (file_exists($filePath)) {
        unlink($filePath);
    }

    if ($uploadOk == 0) {
        echo("Fail");
    } else {
        if (move_uploaded_file($_FILES["imageFile"]["tmp_name"],$filePath)) {
            try {
                $preppedSQL = "UPDATE Users SET profilePic = ? WHERE username = ?";
                $pstmt = $con ->prepare($preppedSQL);
                $pstmt -> bindValue(1,$filePath,PDO::PARAM_STR);
                $pstmt -> bindValue(2,$_SESSION["username"],PDO::PARAM_STR);
                $pstmt -> execute();
                echo($filePath);
            } catch (\Throwable $th) {
                echo($th);
            }
            $con = null;
        } else {
            echo(0);
        }
    }

} 
    else {
        // For a newly created account is created
        $targetDir ="images/";
        $filename = "profilepic_user".getNextIncrement().".png";
        $filePath = $targetDir.$filename;
        $uploadOk = 1;

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        if ($uploadOk == 0) {
            echo("Fail");
        } else {
            if (move_uploaded_file($_FILES["imageFile"]["tmp_name"],$filePath)) {
                try {
                    echo($filePath);
                } catch (\Throwable $th) {
                    echo($th);
                }
                $con = null;
            } else {
                echo(0);
            }
        }
    }

?>
<?php



?>