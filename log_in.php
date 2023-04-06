<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <title>Log In</title>
    <link rel="stylesheet" href="css/log_in.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans'>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/log_in.js"></script>
</head>
<body>
    <article id="container" class="centered">
        <form method="post" id="login_form" action="home_page.php">
            <fieldset>
                    <input type="hidden" id="logged" name="logged" value="true"/>
                <p>
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username"/>
                </p>
                <p>
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password"/>
                </p>
                <input type="submit" class="button" />
            </fieldset>
        </form>
        <button class="button" onclick="location.href='create_account.php'">Create Account</button>
    </article>
</body>
<footer>
    <h1><a href="home_page.php">HOME</a></h1>
</footer>
</html>