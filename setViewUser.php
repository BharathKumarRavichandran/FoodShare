<?php

if(!isset($_SESSION)){ 
    session_start(); 
} 

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("connect.php");
$_SESSION['message']="";

if($_SERVER['REQUEST_METHOD']=='GET'){

	$_SESSION['viewUser'] = $_GET["viewUser"];

}

?>