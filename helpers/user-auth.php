<?php
// File to check whether user is authenticated or not
// Default mail setting
// off
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

//session_start();
$name = $email = "";
if (isset($_SESSION['role'])) {
    $name = $_SESSION['name'];
    $email = (isset($_SESSION['email_id'])) ? $_SESSION['email_id'] : header("Location:index.php?e=n");
    $username = (isset($_SESSION["username"])) ? $_SESSION['username'] : header("Location:index.php?u=n");
} else {
    header("Location:index.php?r=n");
}
?>
