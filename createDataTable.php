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
		Address VARCHAR(500) NOT NULL,
		Latitude DECIMAL(9,6) NOT NULL,
		Longitude DECIMAL(9,6) NOT NULL,
		PickupTime VARCHAR(500) NOT NULL,
		ExpiryDate DATETIME,
		CreationTime DATETIME NOT NULL,
		PRIMARY KEY (id)
		)";
$conn->query($sql);	

$tableName = "chats";
$sql = "CREATE TABLE IF NOT EXISTS $tableName(
		id INT(100) NOT NULL AUTO_INCREMENT,
		Username1 VARCHAR(500) NOT NULL,
		Username2 VARCHAR(500) NOT NULL,
		Message VARCHAR(500) NOT NULL,
		MsgTimeStamp VARCHAR(100) NOT NULL,
		MessageTime DATETIME NOT NULL,
		Status VARCHAR(256) DEFAULT 'unseen',
		PRIMARY KEY (id)
		)";
$conn->query($sql);

$tableName = "totalChats";
$sql = "CREATE TABLE IF NOT EXISTS $tableName(
		id INT(100) NOT NULL AUTO_INCREMENT,
		Username1 VARCHAR(500) NOT NULL,
		Username2 VARCHAR(500) NOT NULL,
		TotalMessages INT(100) NOT NULL,
		PRIMARY KEY (id)
		)";
$conn->query($sql);	

?>