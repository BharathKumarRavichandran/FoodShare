<?php

//File that saves follow data in database
if(!isset($_SESSION)){ 
    session_start(); 
} 

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

include_once("connect.php");
$_SESSION['message']="";

$username = $_SESSION["username"];
$currentUser = $_SESSION["username"];
$tablename = "user";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	if($_POST["purpose"]=="followBtnClick"){

		if($_POST["click"]=="Follow"){

			$currentUser.=",";
			$followUser = $_POST["followUsername"];

			$stmt = $conn->prepare("UPDATE $tablename SET Followers=concat(Followers,?) WHERE username = ?;");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ss",$currentUser,$followUser);
			$stmt->execute();
			$stmt->close();	

			$followUser.=",";

			$stmt = $conn->prepare("UPDATE $tablename SET Following=concat(Following,?) WHERE username = ?;");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ss",$followUser,$username);
			$stmt->execute();
			$stmt->close();

		}
	
		else if($_POST["click"]=="Following"){

			$currentUser.=",";
			$followUser = $_POST["followUsername"];

			$stmt = $conn->prepare("UPDATE $tablename SET Followers= REPLACE(Followers,?,'') WHERE username = ?;");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ss",$currentUser,$followUser);
			$stmt->execute();
			$stmt->close();	

			$followUser.=",";

			$stmt = $conn->prepare("UPDATE $tablename SET Following = REPLACE(Following,?,'') WHERE username = ?;");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ss",$followUser,$username);
			$stmt->execute();
			$stmt->close();

		}

	}

}

?>