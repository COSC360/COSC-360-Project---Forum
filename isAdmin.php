<?php
function isAdmin($username){
    $value = false;
    try {
        //Create connection
        $connString = DBCONN;
        $user = DBUSER;
        $pass = DBPASS;
        $pdo = new PDO($connString,$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Get results
        $sql = "select role from Users where username='".$username."'";
        $result = $pdo->query($sql);
        $data = $result->fetch();
        $data = $data['role'];
        //Close Connection
        $pdo = null;
        if($data === 'admin' ){
            $value = true;
        }

    }
    catch(PDOException $e){ //Catch exception
        die($e->getMessage());
    } 
    return $value;
}
?>