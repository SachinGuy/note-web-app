<?php
session_start();
require_once("dbConnection.php");

//For registration Process
if(isset($_POST["registrationSubmit"]))
{
    $username = trim($_POST["username"], " ");
    $email = trim($_POST["email"], " ");
    $password = trim($_POST["password"], " ");
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $confirmPassword = trim($_POST["confirm-password"], " ");

    $inputErrors = []; //Collection of input errors if any.

    //Check if some of the fields are empty
    if(empty($username) || empty($email) || empty($password) || empty($confirmPassword))
    {
        array_push($inputErrors, "No field can be empty.");
    }
    //Check if username already in database & password confirmation
    $sql = "SELECT * FROM `users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $usernameResult = $stmt->get_result();
    
    //Check if email already in use.
    $sql = "SELECT * FROM `users` WHERE `email` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $emailResult = $stmt->get_result();

    //Check all input with default error message.
    if($usernameResult->num_rows > 0 || $password != $confirmPassword || $emailResult->num_rows > 0)
    {
        array_push($inputErrors,"Credentials doesn't match.");
    }

    if(sizeof($inputErrors) > 0)
    {
        $_SESSION["inputErrors"] = $inputErrors;
        //redirect to registration
        header('Location: registration.php');
        $conn->close();
        exit();
    }else
    {
        //Prepared Statement query(Insert Process)
        $sql = "INSERT INTO `users`(".
        "`username`, `email`, `password`)".
        "VALUES(?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
        //Move on to login page.
        header('Location: login.php');
        $conn->close();
        exit();
    }
}elseif(isset($_POST["loginSubmit"]))
{
    $email = trim($_POST["email"], " ");
    $password = trim($_POST["password"], " ");

    $inputErrors = []; //Collection of input errors if any.

    //Check if some of the fields are empty
    if(empty($email) || empty($password))
    {
        array_push($inputErrors, "No field can be empty.");
    }
    //Check errors
    if(sizeof($inputErrors) > 0)
    {
        $_SESSION["inputErrors"] = $inputErrors;
        //redirect to login
        header('Location: login.php');
        $conn->close();
        exit();
    }else
    {
        //Confirmation of password.
        $sql = "SELECT * FROM `users` WHERE `email` = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            $password_verification = password_verify($password, $row["password"]);
            if($password_verification)
            {
                $_SESSION["userData"]["userName"] = $row["username"];
                $_SESSION["userData"]["email"] = $row["email"];
                header('Location: index.php');
                $conn->close();
                exit();
            }else //If password doesn't match.
            {
                array_push($inputErrors, "Credentials doesn't match.");
                $_SESSION["inputErrors"] = $inputErrors;
                //redirect to login
                header('Location: login.php');
                $conn->close();
                exit();
            }
        }else//Email doesn't exist.
        {
            array_push($inputErrors, "Credentials doesn't match.");
            $_SESSION["inputErrors"] = $inputErrors;
            //redirect to login
            header('Location: login.php');
            $conn->close();
            exit();
        }
    }

    
}