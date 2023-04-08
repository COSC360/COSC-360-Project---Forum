<?php
    session_start();
    include("database.php");
?>
<?php
    try {
        $con = new PDO(DBCONN,DBUSER,DBPASS);
        $con -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (\Throwable $e) {
        echo("Connection Failed ".$e->getMessage()."<br>");
    }
    $sql = "SELECT * FROM Users WHERE username = ?";
    $stmt = $con ->prepare($sql);
    $stmt -> bindValue(1,$_SESSION["username"], PDO::PARAM_STR);
    $stmt -> execute();
    $result = $stmt -> fetch(PDO::FETCH_ASSOC);

    $sql2 = "SELECT COUNT(*) FROM Posts WHERE usernameFK = ?";
    $stmt2 = $con ->prepare($sql2);
    $stmt2 -> bindValue(1,$_SESSION["username"], PDO::PARAM_STR);
    $stmt2 -> execute();
    $result2 = $stmt2 -> fetch();

?>
<!DOCTYPE html>
<html>

<head>
    <title>Account Details</title>
    <link rel="stylesheet" href="css/account.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans' />
</head>

<body>
    <div class="sidebar">
        <ul>
            <li class="active">
                <a href="#"><img id="accDetails" src="images/person-circle.svg" alt="avatar_icon">
                    <span class="iconText">Account Details</span>
                </a>
            </li>
        </ul>
    </div>
    <article>
        <header class="header">
            <div class="navigation">
                <a href="#"><img id="navIcon" src="images/navigation.svg" alt="navigation_icon"></a>
            </div>
            <p>Account Profile</p>
            <ul>
                <li>
                    <a href="home_page.php"><img id="home" src="images/home.svg" alt="home_button"></a>
                </li>
            </ul>
        </header>
        <section class="avatar">
            <figure>
                <img src=<?php echo($result["profilePic"]);?> alt="Profile picture" id="profPic">
                <input type="file" id="imgUpload" name="userImage" accept="image/*">
                <figcaption hidden><a id="addPic" href="">Add/Change Photo</a></figcaption>
            </figure>
        </section>
        <section class="userInfo">
            <p id="username"><?php echo($result["username"]);?></p>
            <p id="joinDate">Member Since: 
                <?php 
                    $tstamp = strtotime($result["dateJoined"]); 
                    echo(date("Y-m-d",$tstamp));
                ?>
            </p>
            <form method="post" action="updateAcc.php" name="accContent">
                <label for="uname">Username:</label>
                <input type="text" name="uname" value=<?php echo($result["username"]);?> readonly>
                <br><br>
                <label for="fname">First Name:</label>
                <input type="text" name="fname" value=<?php echo($result["firstName"]);?> readonly>
                <br><br>
                <label for="lname">Last Name:</label>
                <input type="text" name="lname" value=<?php echo($result["lastName"]);?> readonly>
                <br><br>
                <label for="bday">Birthday:</label>
                <input type="text" name="bday" value=<?php echo($result["birthdate"]);?> readonly>
                <br><br>
                <label for="email">Email:</label>
                <input type="text" name="email" value=<?php echo($result["email"]);?> readonly>
                <br><br>
                <label for="postCount">Number of Posts:</label>
                <input type="number" name="postCount" value=<?php echo($result2[0]);?> readonly>
                <br><br>
                <button id="editProfile" type="button" form="accContent">Edit Profile</button>
                <input id="saveProfile" type ="submit" value="Save Changes">
                <input id="cancelChanges" type ="button" value="Cancel">
            </form>
        </section>
        <footer class="footer">
        </footer>
        </footer>
    </article>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/account.js"></script>
</body>

</html>