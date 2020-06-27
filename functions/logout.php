<?php
//Unset all sessions
session_start();
session_unset();
//redirect to the login page
header("Location: ../login.php");
?>