<?php
session_start();
require_once("dbConnection.php");

//Handle saving note.
if(isset($_POST["submitNote"]))
{
    $title = trim($_POST["noteTitle"], " ");
    $content = trim($_POST["noteContent"], " ");

    $inputErrors = [];
    if (empty($title)) 
    {
        array_push($inputErrors, "Note's title can't be empty!");
    }

    if(sizeof($inputErrors) > 0)
    {
        $_SESSION['$inputErrors'] = $inputErrors;
        header("Location: ../index.php");
        $conn->close();
        exit();
    }else
    {
        $user_id = $_SESSION['userData']['userId'];
        //mysql date format datetime yyyy-mm-dd hh:mi:ss
        date_default_timezone_set('UTC');
        $created_at = date("Y-m-d h:i:s");
        $sql = "INSERT INTO `notes`(".
                "`user_id`, `title`, `content`, `created_at`) ".
                "VALUES(?,?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $user_id, $title, $content, $created_at);
        $stmt->execute();
        //Store notes in session
        $sql = "SELECT * FROM `notes` WHERE `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_id);
        $stmt->execute();
        $notesResult = $stmt->get_result();
        $notes = []; //Empty array of notes
        if($notesResult->num_rows > 0)
        {
            while ($row = $notesResult->fetch_assoc())
            {
                array_push($notes, $row);
            }
            $_SESSION['userData']['userNotes'] = $notes;
        }else
        {
            $_SESSION['userData']['userNotes'] = null;
        }
        //Move on to home page
        header("Location: ../index.php");
        $conn->close();
        exit();
    }
}elseif (isset($_POST['updateNote'])) {
    $title = trim($_POST["noteTitle"], " ");
    $content = trim($_POST["noteContent"], " ");
    $noteId = trim($_POST['noteId'], " ");
    $inputErrors = [];
    if (empty($title)) 
    {
        array_push($inputErrors, "Note's title can't be empty!");
    }

    if(sizeof($inputErrors) > 0)
    {
        $_SESSION['$inputErrors'] = $inputErrors;
        header("Location: ../index.php");
        $conn->close();
        exit();
    }else
    {
        //Update note.
        $sql = "UPDATE `notes` SET `title` = ?, `content` = ? ".
                "WHERE `note_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $title, $content, $noteId);
        $stmt->execute();
        //Store notes in session
        $sql = "SELECT * FROM `notes` WHERE `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['userData']['userId']);
        $stmt->execute();
        $notesResult = $stmt->get_result();
        $notes = []; //Empty array of notes
        if($notesResult->num_rows > 0)
        {
            while ($row = $notesResult->fetch_assoc()) 
            {
                array_push($notes, $row);
            }
            $_SESSION['userData']['userNotes'] = $notes;
        }else{
            $_SESSION['userData']['userNotes'] = null;
        }
        //Move on to home page
        header("Location: ../index.php");
        $conn->close();
        exit();
    }
}elseif (isset($_POST['deleteNote'])) {
    if(!empty($_POST['noteId']))
    {
        $noteId = trim($_POST['noteId'], " ");
        //Delete Note
        $sql = "DELETE FROM `notes` WHERE `note_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $noteId);
        $stmt->execute();
        //Store notes in session
        $sql = "SELECT * FROM `notes` WHERE `user_id` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['userData']['userId']);
        $stmt->execute();
        $notesResult = $stmt->get_result();
        $notes = []; //Empty array of notes
        if($notesResult->num_rows > 0)
        {
            while ($row = $notesResult->fetch_assoc()) 
            {
                array_push($notes, $row);
            }
            $_SESSION['userData']['userNotes'] = $notes;
        }else{
            $_SESSION['userData']['userNotes'] = null;
        }
        //Move on to home page
        header("Location: ../index.php");
        $conn->close();
        exit();
    }
}
