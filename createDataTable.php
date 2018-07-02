<?php

if(!isset($_SESSION)){ 
    session_start(); 
}

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("connect.php");
$username = $_SESSION["username"];

$sql = "USE FoodShare;";
$conn->query($sql);

$tableName = "foods";

$sql = "CREATE TABLE IF NOT EXISTS $tableName(
		id INT(100) NOT NULL AUTO_INCREMENT,
		Username VARCHAR(500) NOT NULL,
		Type VARCHAR(500) NOT NULL,
		Title VARCHAR(500) NOT NULL,
		Description VARCHAR(500),
		Latitude DECIMAL(9,6) NOT NULL,
		Longitude DECIMAL(9,6) NOT NULL,
		PickupTime VARCHAR(500) NOT NULL,
		CreationTime DATETIME NOT NULL,
		Expires DATETIME,
		PRIMARY KEY (id)
		)";
$conn->query($sql);	

?>