<?php
session_start();
require_once('dbConnection.php');
//If not logged in
if(!isset($_SESSION['userData']))
{
    $_SESSION["inputErrors"] = array();
    array_push($_SESSION["inputErrors"], "You need to login first before accessing home page.");
    header('Location: ../login.php');

    exit();
}
//If request made.
if(isset($_POST['singleNoteBtn']))
{
    $noteId = trim($_POST['noteId'], " ");
    
    $sql = "SELECT * FROM `notes` WHERE `note_id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $noteId);
    $stmt->execute();
    $result = $stmt->get_result();
    //Check if the noteId exists.
    if($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $conn->close();
?>
<!--Top Section-->
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Login Registration System</title>
    <link rel='stylesheet' href='../css_files/style.css'>
<body>
    <!-- Top NavBar-->
    <div class='topNav'>
        <ul>
            <li class='li-float-left'>
                <img class = 'logo-img'src='../assets/sachinlogo.png' alt='Sachin Timilsina Logo'>
            </li>
            <li class='li-float-right logout'><a href='#' onclick="logoutConfirmation();">Logout</a></li>
            <?php 
            echo "<li class= 'li-float-right'><a class='welcomeMsg'>".
            "Greetings ". $_SESSION['userData']['userName']. " | ". $_SESSION["userData"]["email"]."</a></li>"
            ?>
        </ul>
    </div>

    <!--Edit Note -->
    <div class="noteContainer">
        <h2>Edit Note</h2>
        <form action="noteProcessing.php" method="post">
            <input type='hidden' name='noteId' value='<?php echo $noteId ?>'>
            <input type="text" name="noteTitle" id="noteTitle"  value = "<?php echo $row['title']?>"required>
            <textarea name="noteContent" id="noteContent" ><?php echo $row['content'];?></textarea>
            <div class="noteAction">
                <input type="submit" name="updateNote" value="Update">
                <input type="submit" class= "deleteBtn" name="deleteNote" value="Delete"></input>
            </div>
        </form>
    </div>

    <!--Bottom NavBar-->
    <div class='bottomNav'>
        <img class = 'logo-img' src='../assets/sachinlogo.png' alt='Sachin Timilsina Logo'>";?>
        <?php echo "<span class='copyrightTxt'>Copyright ".date('Y')." By Sachin Timilsina. All Rights Reserved.</span>";?>
    </div>
</body>
</html>

    
<?php

    }else //If note doesn't exist.
    {
        header('Location: index.php');
        $conn->close();
        exit();
    }
}else{//If empty link redirect.
    header('Location: ../index.php');
    exit();
}