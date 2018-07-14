<?php

$sql = "CREATE DATABASE IF NOT EXISTS FoodShare;";
$conn->query($sql);

$sql = "USE FoodShare;";
$conn->query($sql);

$sql = "CREATE TABLE IF NOT EXISTS user(
		id INT(100) NOT NULL AUTO_INCREMENT,
		username VARCHAR(100) NOT NULL,
		email VARCHAR(320) NOT NULL,
		password VARCHAR(256) NOT NULL,
		Following VARCHAR(500) NOT NULL,
		Followers VARCHAR(500) NOT NULL,
		DisplayImagePath VARCHAR(2000) DEFAULT 'display_pictures/default_dp.jpg',
		PRIMARY KEY (id,username)
		)";
$conn->query($sql);

?>