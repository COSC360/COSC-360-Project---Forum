<?php
session_start();
include("database.php");
if (isset($_SESSION["username"])) {
    header("Location: http://localhost/COSC-360-Project---Forum/home_page.php"); 
}
?>

<!DOCTYPE html>
<html>

<head lang="en">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/create_account.css" />
    <link rel="stylesheet" href='https://fonts.googleapis.com/css?family=Smooch Sans'/>
    <title>Create Account</title>
</head>

<body>
    <article>
        <header class="header">
            <a href="log_in.php"><img src="images/backArrow.svg" id="backPage" alt="back-arrow" width="50" height="50"></a>
            <p>Create Account</p>
            <a href="#"><img src="images/help-circle (1).svg" id="help" alt="help-circle-outline" width="50" height="50"></a>
        </header>
        <section class="articleLeft">
            <figure id="avatar">
                <img src="images/profile.svg" alt="Profile picture" id="profPic">
                <form id="profpic" method="post" action="profilePic.php" enctype="multipart/form-data">
                    <input type="file" id="imgUpload" name="userImage">
                </form>
                <figcaption class="addPicHolder"><a id="addPic" href="#">Add Photo</a></figcaption>
            </figure>
        </section>
        <section class="articleRight">
            <fieldset id="formHolder">
                <form method="post" action="accSetup.php" id="info">
                    <label for="fname">First Name:</label>
                    <br>
                    <input type="text" name="fname" placeholder="Your name">
                    <br><br>
                    <label for="lname">Last Name:</label>
                    <br>
                    <input type="text" name="lname" placeholder="Your last name">
                    <br><br>
                    <label for="uname">Username:</label>
                    <br>
                    <input type="text" name="uname">
                    <br><br>
                    <label for="bday">Birthday:</label>
                    <br>
                    <select id="month" name="bdayMonth">
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                    <select id="day" name="bdayDate">
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                        <option value="21">21</option>
                        <option value="22">22</option>
                        <option value="23">23</option>
                        <option value="24">24</option>
                        <option value="25">25</option>
                        <option value="26">26</option>
                        <option value="27">27</option>
                        <option value="28">28</option>
                        <option value="29">29</option>
                        <option value="30">30</option>
                        <option value="31">31</option>
                    </select>
                    <input type="number" id="year" name="bdayYear" min="1923" max="2007" value="2007">
                    <br><br>
                    <label for="email">Email:</label>
                    <br>
                    <input type="text" name="email" placeholder="E.g. youremail@gmail.com">
                    <br><br>
                    <label for="pword">Create Password:</label>
                    <br>
                    <input type="password" name="pword">
                    <br><br>
                    <label for="repword">Re-Enter Password:</label>
                    <br>
                    <input type="password" name="repword">
                    <br><br>
                </form>
            </fieldset>
        </section>
        <section class="submit">
            <button id="createAcc" type="submit" form="info">Create Account</button>
        </section>
        <footer class="footer">
            <p></p>
        </footer>
    </article>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="scripts/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="scripts/create_account.js"></script>
</body>

</html>
<?php

?>
