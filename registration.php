<?php 
session_start();
//If already logged in
if(isset($_SESSION['userData']))
{
    header('Location: index.php');
    exit();
}
require_once("assets/topHtml.php");
?>
    <!--Registration Form-->
<?php 
    //If any input errors during registration.
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
        <form class="registrationForm" action="userProcessing.php" method="post">
            <h2>Register</h2>
            <label for="username">Username</label><br>
            <input type="text" name="username" id="username" placeholder="Enter username" required><br>
            <label for="email">Email</label><br>
            <input type="email" name="email" id="email" placeholder="Enter email" required><br>
            <label for="password">Password</label><br>
            <input type="password" name="password" id="password" placeholder="Enter Password" minlength="8" required><br>
            <input type="checkbox" onclick="toggle('password');"><span class="iconMsg">Show Password</span><br>
            <label for="confirmPassword">Confirm Password</label><br>
            <input type="password" name="confirm-password" id="confirmPassword" placeholder="Re-Enter Password" minlength="8" required><br>
            <input type="checkbox" onclick="toggle('confirmPassword');"><span class="iconMsg">Show Password</span><br>
            <input class="submitBtn" type="submit" name="registrationSubmit" value="Submit"></input>
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
?>