<?php
// Include this in your "top stuff" file

// retrieve session data
session_start();

// if there is no username, kick the user back to login page
if(!isset($_SESSION['Username']) || empty($_SESSION['Username'])){
	header("location: login.php");
	exit;
}
?>