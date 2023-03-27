<?php
 define("DBHOST","localhost");
 define("DBNAME","cosc360project");
 define("DBUSER","cosc360projUser");
 define("DBPASS","cosc360project");
 try {
     $con = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
     $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 } catch (PDOException $e) {
     echo("Connection Failed ".$e->getMessage()."<br>");
 }
?>