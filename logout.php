<?php
session_start();
//end session.
if(isset($_SESSION['userData']))
{
    unset($_SESSION['userData']);
    session_destroy();
    session_write_close();
    header('Location: login.php');
    exit();
}