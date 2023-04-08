<?php
    session_start();
    date_default_timezone_set('America/Los_Angeles');
    require 'database.php';
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
        $sql = "select * from Boards";
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

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Make Post</title>

    <link rel="stylesheet" href="css/make_post.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/make_post.js"></script>
</head>
<body>
    <h1><a href="home_page.php">HOME</a>
    <article id="container" class="centered">
    <form method="POST" id="make_post" action="upload_post.php" enctype="multipart/form-data">
        <fieldset>
            <legend><h1>Make Post</h1></legend>
            <p>
                <input type="hidden" name="username" id="username" value="<?php echo $_SESSION['username']; ?>">
                <input type="hidden" name="date" id="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
            </p> 
            <p>
               <label>TITLE</label><br/>
               <input type="text" name="title" size="75" class="required" id="title_input"/>
            </p>
            <p>
               <label>BOARD</label><br/>
               <select name="board" id="board">
               <?php
                $boards = getBoardList();
                $i=0;
                while($i<count($boards)){
                    $iName = $boards[$i]['name'];
                    echo "<option value=\"".$iName."\">#".strtoupper($iName)."</option>";
                    $i++;
                }
                ?>
               </select>
            </p>
            <p>
               <label>TEXT</label><br/>
               <textarea name="text" rows="3" size="75" class="required" id="text"></textarea>
            </p>
            <p>
                <label>IMAGE</label><br/>
                <input type="file" id="image" name="image" accept="image/*"></input>
            </p>
            <input type="submit" name="submit" class="button" value="upload"></input>
        </fieldset>
    </form>
    </article>
</body>
</body>
<footer></footer>
</html>