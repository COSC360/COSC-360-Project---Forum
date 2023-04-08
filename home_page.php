<?php
    session_start();
    require "database.php";
    require "isAdmin.php";
?>

<?php
    if(isset($_POST["sort"])){
        $sort_value=$_POST["sort"];
    }
?>

<?php 
    function getBoard(){
        if(isset($_GET["board"])){
            $board=$_GET["board"];
        }else{
            $board = "general";
        }
        return $board;
    }
?>

<?php
function getBoardList(){
    //Connect to Database
    try {
        $connString = DBCONN;
        $user = DBUSER;
        $pass = DBPASS;
        $pdo = new PDO($connString,$user,$pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //Get results
        $sql = "select * from boards";
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
            $sql = "select profilePic from Users where username='".$username."'";
            $result = $pdo->query($sql);
            $data = $result->fetch();
            $data = $data['profilePic'];
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
//Check if user has admin rights
    $isAdmin = false;
    if(isset($_SESSION['username']) && isset($_SESSION['logged_in'])){
        if($_SESSION['logged_in']==true){
            $isAdmin=isAdmin($_SESSION['username']);
        }
    }
?>

<?php
    function likedPosts($username){
        try {
            //Create connection
            $connString = DBCONN;
            $user = DBUSER;
            $pass = DBPASS;
            $pdo = new PDO($connString,$user,$pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //Get results
            $sql = "select id from LikedBy, Posts where LikedBy.postIDFK=Posts.id and LikedBy.usernameFK='".$username."' and Posts.boardFK='".getBoard()."'";
            $result = $pdo->query($sql);
            $data = array();
            $i = 0;
            while($row  = $result->fetch()) {
                $data[$i] = $row['id'];
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
    function displayPosts($posts, $isAdmin){
        $i=0;
        $likedPosts = array();
        if(isset($_SESSION["username"])){
            $likedPosts = likedPosts($_SESSION['username']);
        }
        while($i<count($posts)){
            echo "<div class=\"post\">";
            if(!empty($posts[$i]['image'])){
                echo "<img src=\"images/".$posts[$i]['image']."\" class=\"post_image\">";
            }
            
            echo "<div class=\"post_text\">";
            if(isset($_SESSION['username']) && isset($_SESSION['logged_in'])){
                if($isAdmin && $_SESSION['logged_in']==true){
                    echo "<h3><a href=\"post.php?post=".$posts[$i]['id']."\">".$posts[$i]['title']."</a><button class=\"admin_button\" name=\"".$posts[$i]['title']."\" value=\"".$posts[$i]['id']."\">DELETE</button></h3>";
                }else{
                    echo "<h3><a href=\"post.php?post=".$posts[$i]['id']."\">".$posts[$i]['title']."</a></h3>";
                }
            }else{
                echo "<h3><a href=\"post.php?post=".$posts[$i]['id']."\">".$posts[$i]['title']."</a></h3>";
            }
            echo "<p class=\"post_text_main\">".substr($posts[$i]['postText'],0,360)."...</p>
                <p class=\"post_info\"><time>".$posts[$i]['postDate']."</time>   POSTED BY: ".$posts[$i]['usernameFK']."</p>
                </div><div class=\"likes\">";
                
            if(in_array($posts[$i]['id'],$likedPosts)){
                echo "<button type=\"button\" value=\"".$posts[$i]['id']."\" class=\"unlike\"><img class=\"liked\" src=\"images/liked.png\"></button>";
            }else{
                echo "<button type=\"button\" value=\"".$posts[$i]['id']."\" class=\"like\"><img class=\"not_liked\" src=\"images/not_liked.png\"></button>";
            }
            echo      "<p class=\"like_num\">".$posts[$i]['likes']."</p></div></div>";
            $i++;
        }
    }
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Home Page</title>

    <link rel="stylesheet" href="css/home_page.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/home_page.js"></script>
</head>
<body>
    <header id="masthead">
        <h1><a href="home_page.php">HOME</a>┃<a href="search.php">SEARCH</a></h1>
        <div id="profile">
        
            <?php 
                if($_SESSION['logged_in']==true && isset($_SESSION['username'])){
                    echo "<h1 class=\"profile_bar\"><a href=\"logout.php\">LOG OUT</a>┃</h1>";
                    echo "<h1 class=\"profile_bar\"><a href=\"make_post.php\">MAKE POST</a>┃</h1>";
                    echo "<h1 class=\"profile_bar\"><a href=\"account.php\">MY ACCOUNT</a>┃</h1>
                    <img id=\"profile_pic\" src=\"".getProfilePic($_SESSION['username'])."\">";

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
            <?php
                $boards = getBoardList();
                $i=0;
                while($i<count($boards)){
                    $iName = $boards[$i]['name'];
                    echo "<li><a href=\"home_page.php?board=".$iName."\">#".strtoupper($iName)."</a></li>";
                    $i++;
                }
            ?>
            </ul>
        </article>
        <article id="center">
            <div id="top">
                <form method="POST" id="sort_by">
                    <label for="sort">SORT BY:</label>
                    <select name="sort" id="sort" onchange="this.form.submit()">
                        <?php 
                        if(isset($_POST["sort"])){
                                $sort_value=$_POST["sort"];
                                if($sort_value=='likes'){
                                    echo "<option value=\"postDate\">DATE</option>
                                            <option value=\"likes\" selected>LIKES</option>";
                                }else if($sort_value=='postDate'){
                                    echo "<option value=\"postDate\" selected>DATE</option>
                                            <option value=\"likes\">LIKES</option>";
                                }
                        }else{
                            echo "<option value=\"postDate\">DATE</option>
                                    <option value=\"likes\" selected>LIKES</option>";
                        }
                        ?>
                    </select>
                </form>
                <?php
                    echo "<h2 id=\"board_name\">#".strtoupper(getBoard())."</h2>";
                ?>
            </div>
            <article id="post_list">
                <?php
                //Connect to Database
                try {
                    $connString = DBCONN;
                    $user = DBUSER;
                    $pass = DBPASS;
                    $pdo = new PDO($connString,$user,$pass);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    //Get results
                    $sql = "select * from Posts where boardFK = '".getBoard()."'";
                    $result = $pdo->query($sql);

                    $posts = array();
                    $i = 0;
                
                    while($row  = $result->fetch()) {
                        $posts[$i] = $row;
                        $i++;
                    }
                    //Close Connection
                    $pdo = null;
                }
                catch(PDOException $e){ //Catch exception
                    die($e->getMessage());
                }
                //Sort results
                if(isset($_POST["sort"])){
                    usort($posts, function ($item1, $item2) {
                        return $item2[$_POST["sort"]] <=> $item1[$_POST["sort"]];
                    });
                }else{
                    usort($posts, function ($item1, $item2) {
                        return $item2['likes'] <=> $item1['likes'];
                    });
                }
                //Display results
                displayPosts($posts, $isAdmin);
                ?>
            </article>
        </article>
    </div>
</body>
<footer></footer>
</html>
