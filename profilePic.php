<?php
session_start();
include("database.php");

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
    $filename = "profilepic_user".$userID.strtolower(basename($_FILES["imageFile"]["name"]));
    $filePath = $targetDir.$filename;
    $imageFileType = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
    $uploadOk = 1;

    $allowedExts = array("jpg","jpeg","png");

    if (!in_array($imageFileType,$allowedExts)) {
    $uploadOk = 0;
    }

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
        $filename = "profilepic_user".$userID.strtolower(basename($_FILES["imageFile"]["name"]));
        $filePath = $targetDir.$filename;
        $imageFileType = strtolower(pathinfo($filePath,PATHINFO_EXTENSION));
        $uploadOk = 1;

        $allowedExts = array("jpg","jpeg","png");

        if (!in_array($imageFileType,$allowedExts)) {
        $uploadOk = 0;
        }

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