<?php
    session_start();
    date_default_timezone_set('America/Los_Angeles');
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
                  <option value="general">#GENERAL</option>
                  <option value="music">#MUSIC</option>
                  <option value="politics">#POLITICS</option>
                  <option value="news">#NEWS</option>
                  <option value="movies">#MOVIES</option>
                  <option value="videogames">#VIDEOGAMES</option>
                  <option value="memes">#MEMES</option>
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