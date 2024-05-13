<?php
session_start();
//If not logged in
if(!isset($_SESSION['userData']))
{
    $_SESSION["inputErrors"] = array();
    array_push($_SESSION["inputErrors"], "You need to login first before accessing home page.");
    header('Location: login.php');

    exit();
}
?>
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Login Registration System</title>
    <link rel='stylesheet' href='css_files/style.css'>
<body>
    <!-- Top NavBar-->
    <div class='topNav'>
        <ul>
            <li class='li-float-left'>
                <img class = 'logo-img'src='assets/sachinlogo.png' alt='Sachin Timilsina Logo'>
            </li>
            <li class='li-float-right logout'><a href='#' onclick="logoutConfirmation();">Logout</a></li>
            <li class='li-float-right'><a href='index.php'>Home</a></li>
        </ul>
    </div>
    <?php
    if(isset($_SESSION['userData']))
    {
        echo"
        <div class= 'welcomeContainer'>
            <p class= 'welcomeMsg'>".
            "Greetings ". $_SESSION['userData']['userName']. ". Welcome to your page that you signed in with ". $_SESSION["userData"]["email"].
            ".</p>
        </div>
        ";
    }
    ?>
    <script>
        function logoutConfirmation()
        {
            if(confirm("Logout?")===true)
            {
                window.location.replace("/LoginRegistrationSystem/logout.php");
            }

        }
    </script>
<?php
require_once('assets/bottomHtml.php');

