<?php
require_once("db.php");
$dbHost = $DB_HOST;
$dbUser = $DB_USER;
$dbPassword = $DB_PASSWORD;
$db = $DB_NAME;

//Report Errors as exceptions
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
//Connect to database
try{
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $db);
    //Sets error reporting charset.
    $conn->set_charset("utf8mb4");
}catch(Exception $e)
{
    //if error log to log file.
    error_log($e->getMessage() , 3, "errors.log");
    exit("Error Connecting to Database");
}