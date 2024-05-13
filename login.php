<?php
session_start();
require_once("assets/topHtml.php");
?>
<?php
    //If already logged in
    if(isset($_SESSION['userData']))
    {
        header('Location: index.php');
        exit();
    }
    //If any input errors while logging.
    if(isset($_SESSION["inputErrors"]))
    {
        echo"<div class='errorContainer'>";
        foreach ($_SESSION["inputErrors"] as $value) 
        {
            echo"<span class= 'errorMsg'>". $value ."</span><br>";
        }
        echo"</div>";
        unset($_SESSION["inputErrors"]);
    }
?>
    <div class="formContainer">
        <form class="loginForm" action="userProcessing.php" method="post">
            <h2>Login</h2>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" placeholder="Enter email" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="Enter Password" minlength="8" required><br>
            <input type="checkbox" onclick="toggle('password');"><span class="iconMsg">Show Password</span><br>
            <a href="registration.php">Haven't registered yet? Click here</a>
            <input class="submitBtn" type="submit" name="loginSubmit" value="Submit"></input>
        </form>

    </div>
    <script>
        function toggle(id) {
            let element = document.getElementById(id);
            if(element.type === "password")
            {
                element.type = "text";
            }else
            {
                element.type = "password";
            }
        }
    </script>
<?php
require_once("assets/bottomHtml.php");