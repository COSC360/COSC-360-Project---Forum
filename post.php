<?php
    session_start();
    include "database.php";
?>

<?php
    $postData = array();
    $postID;
    if(isset($_GET["post"])){
        $postData = getData($_GET["post"]);
        $postID=$_GET["post"];
    }
?>

<?php
    function getData($id){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select * from Posts where id=".$id;
            $result = $pdo->query($sql);
            $data = array();
            $row  = $result->fetch();
            $data = $row;
            //Close Connection
            $pdo = null;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $data;
    }
?>

<?php
    function getComments($id){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select commentID, usernameFK, text, date, likes, profilepic
                from Comments, Users where Comments.usernameFK=Users.username and Comments.postIDFK=".$id;
            $result = $pdo->query($sql);
            $data = array();
            $i = 0;
            while($row  = $result->fetch()) {
                $data[$i] = $row;
                $i++;
            }
            //Close Connection
            $pdo = null;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $data;
    }
?>

<?php
    function getProfilePic($username){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select profilepic from Users where username='".$username."'";
            $result = $pdo->query($sql);
            $data = $result->fetch();
            $data = $data['profilepic'];
            //Close Connection
            $pdo = null;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $data;
    }
?>

<?php
    function displayComments($comments,$postID){
        $i=0;
        while($i<count($comments)){
            echo "<article class=\"comment\"><div class=\"comment_profile\">";
            echo "<img src=\"images/".$comments[$i]['profilepic']."\" class=\"comment_pic\">";
            echo "<p class=\"comment_date\"><time> ".$comments[$i]['date']."</time></p></div>";
            echo "<div class=\"comment_text\"><h4>".$comments[$i]['usernameFK']."</h4>";
            echo "<p>".$comments[$i]['commentText']."</p></div>";
            if($_SESSION['logged_in']==true && isset($_SESSION['username'])){
                if(in_array($comments[$i]['commentID'],likedComments(($_SESSION['username']),$postID))){
                    echo "<div class=\"comment_likes\"><button type=\"button\" value=\"".$comments[$i]['commentID']."\" class=\"unlike\"><img class=\"liked\" src=\"images/liked.png\"></button>";
                }else{
                    echo "<div class=\"comment_likes\"><button type=\"button\" value=\"".$comments[$i]['commentID']."\" class=\"like\"><img class=\"not_liked\" src=\"images/not_liked.png\"></button>";
                }
            }else{
                echo "<div class=\"comment_likes\"><button type=\"button\" value=\"".$comments[$i]['commentID']."\" class=\"like\"><img class=\"not_liked\" src=\"images/not_liked.png\"></button>";
            }
            echo "<p class=\"comment_like_number\">".$comments[$i]['likes']."</p>";
            echo "</div></article>";
            $i++;
        }
        
    }
?>

<?php
    function likedComments($username, $postID){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select commentIDFK from CommentsLikedBy, Comments where Comments.postIDFK=".$postID." and CommentsLikedBy.usernameFK='".$username."'";
            $result = $pdo->query($sql);
            $data = array();
            $i = 0;
            while($row  = $result->fetch()) {
                $data[$i] = $row['commentIDFK'];
                $i++;
            }
            //Close Connection
            $pdo = null;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $data;
    }
?>

<?php
    function isPostLiked($id, $username){
        try {
            $value;
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select * from LikedBy where postIDFK=".$id." and usernameFK='".$username."'";
            $result = $pdo->query($sql);
            if ($result->rowCount() > 0) { 
                $value = true;
            }else{
                $value = false;
            }
            //Close Connection
            $pdo = null;
            return $value;
        }
        catch(PDOException $e){ //Catch exception
            die($e->getMessage());
        }
        return $data;
    }
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Post</title>
    <link rel="stylesheet" href="css/post.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/post.js"></script>
</head>
<body>
    <header id="masthead">
        <h1><a href="home_page.php">HOME</a></h1>
        <div id="profile">
            <?php 
                if($_SESSION['logged_in']==true && isset($_SESSION['username'])){
                    echo "<h1 class=\"profile_bar\"><a href=\"logout.php\">LOG OUT</a>┃</h1>";
                    echo "<h1 class=\"profile_bar\"><a href=\"make_post.php\">MAKE POST</a>┃</h1>";
                    echo "<h1 class=\"profile_bar\"><a href=\"account.html\">MY ACCOUNT</a>┃</h1>
                    <img id=\"profile_pic\" src=\"images/".getProfilePic($_SESSION['username'])."\">";
                }else{
                    echo "<h1 class=\"profile_bar\"><a href=\"log_in.php\">LOG IN</a></h1>";
                }
            ?>
        </div>
    </header>
    <div id="main">
        <article id="sidebar">
            <h2>BOARDS</h2>
            <ul>
                <li><a href="home_page.php?board=general">#GENERAL<a></li>
                <li><a href="home_page.php?board=music">#MUSIC</a></li>
                <li><a href="home_page.php?board=politics">#POLITICS</a></li>
                <li><a href="home_page.php?board=news">#NEWS</a></li>
                <li><a href="home_page.php?board=movies">#MOVIES</a></li>
                <li><a href="home_page.php?board=videogames">#VIDEOGAMES</a></li>
                <li><a href="home_page.php?board=memes">#MEMES</a></li>
            </ul>
        </article>
        <article id="center">
            <div id="top">
                <div class="likes">
                    <?php
                        if($_SESSION['logged_in']==true && isset($_SESSION['username'])){
                            if(isPostLiked($postID,$_SESSION['username'])){
                                echo "<button type=\"button\" value=\"".$postID."\" class=\"post_unlike\"><img class=\"liked\" src=\"images/liked.png\"></button>";
                            }else{
                                echo "<button type=\"button\" value=\"".$postID."\" class=\"post_like\"><img class=\"not_liked\" src=\"images/not_liked.png\"></button>";
                            }
                        }else{
                            echo "<button type=\"button\" value=\"".$postID."\" class=\"post_like\"><img class=\"not_liked\" src=\"images/not_liked.png\"></button>";
                        }
                    ?>
                        <p class="like_number"><?php echo $postData['likes'] ?></p>
                </div>
                <h2 id="post_title"><a href="home_page.php?board=<?php echo $postData['boardFK'] ?>">#<?php echo strtoupper($postData['boardFK']) ?></a> > <?php echo strtoupper($postData['title']) ?></h2>
                <p id="post_by">by <?php echo $postData['username'] ?> (<time> <?php echo $postData['date'] ?></time>)</p>
            </div>
            <div id="post">
                <div id="content">
                    <?php
                        if(!empty($postData['image'])){
                            echo "<img id=\"post_image\" src=\"images/".$postData['image']."\">";
                        }  
                    ?>
                    <p id="post_text"> <?php echo $postData['postText'] ?></p>
                </div>
                <div id="comments">
                    <?php
                        $comments = getComments($postID);
                        displayComments($comments,$postID);
                    ?>
                </div>
            </div>
        </article>
    </div>
</body>
<footer></footer>
</html>