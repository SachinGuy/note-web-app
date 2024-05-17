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
            <?php 
            echo "<li class= 'li-float-right'><a class='welcomeMsg'>".
            "Greetings ". $_SESSION['userData']['userName']. " | ". $_SESSION["userData"]["email"]."</a></li>"
            ?>
        </ul>
    </div>
    
    <!-- Take Notes Section-->
    <div class="noteContainer">
        <h2>Take Note</h2>
        <form action="model/noteProcessing.php" method="post">
            <input type="text" name="noteTitle" id="noteTitle" placeholder="Title" required>
            <textarea name="noteContent" id="noteContent" placeholder="Write something..."></textarea>
            <div class="noteAction">
                <input type="submit" name="submitNote" value="Save">
                <button id="cancelNoteBtn">Cancel</button>
            </div>
            
        </form>
    </div>
    <!-- Display Notes Section -->
    <div class="notesContainer">
        <h1>Notes Section:</h1>
        <div class="notesInnerContainer">
        <?php
        if(!empty($_SESSION['userData']['userNotes']))
        {
            foreach ($_SESSION['userData']['userNotes'] as $notes) {
                echo"
                <div class='singleNoteContainer'>".
                "<form action='model/editNote.php' method='post'>".
                    "<input type='hidden' name='noteId' value='".$notes['note_id'] ."'>".
                    "<span class = 'singleNoteDate' name='notesDate'> Created At: ". $notes['created_at']." UTC</span>".
                    "<textarea class= 'singleNoteField singleNoteTitle' name='notesTitle' id ='notesTitle' disabled>".$notes['title']."</textarea><br>".
                    "<textarea class= 'singleNoteField singleNoteContent' name='notesContent' id ='notesContent' disabled>".$notes['content']."</textarea>".
                    "<input type='submit' class='singleNoteBtn' name='singleNoteBtn' value='Edit'></input>".
                "</form>".
                "</div>";
            }
        }else
        {
            echo"
                <div class='singleNoteContainer'>".
                    "<textarea class= 'singleNoteField' name='notesTitle'>No notes made till now.</textarea>".
                "</div>";
        }
        
        ?>
        </div>
    </div>
    <script>
        function logoutConfirmation()
        {
            if(confirm("Logout?")===true)
            {
                window.location.replace("/LoginRegistrationSystem/logout.php");
            }

        }
        //Handle note cancel button
        document.getElementById('cancelNoteBtn').addEventListener('click', 
            function(event){
                //Prevent btn default behavior
                event.preventDefault();
                let title =document.getElementById('noteTitle');
                let content =document.getElementById('noteContent');
                title.value = "";
                content.value = "";
            }
        )
    </script>
<?php
require_once('assets/bottomHtml.php');

