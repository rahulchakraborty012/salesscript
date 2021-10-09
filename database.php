<?php
function connect()
{
    $user = "root";
    $host = "localhost";
    $pass = "rahul";
    $db = "rightbiz";
    $mysqli = new mysqli($host,$user,  $pass, $db);
    if($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }
    return $mysqli;
}
?>