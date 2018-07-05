<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

$username = $_SESSION['username'];
$tablename = "foods";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	if($_POST['purpose']=="addListing"){

		$type = $_POST['type'];
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$address = $_POST['address'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$pickupTime = $_POST['time'];
		$expiryDate = $_POST['expiryDate'];
		$creationDate = date('Y-m-d H:i:s');

		$stmt = $conn->prepare("INSERT INTO $tablename(Username,Type,Title,Description,Address,Latitude,Longitude,PickupTime,ExpiryDate,CreationTime) VALUES(?,?,?,?,?,?,?,?,?,?);");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssssddsss",$username,$type,$title,$desc,$address,$latitude,$longitude,$pickupTime,$expiryDate,$creationDate);
		$stmt->execute();
		$stmt->close();

	}

	else if($_POST['purpose']=="editListing"){

		$id = $_POST['id'];
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$pickupTime = $_POST['pickupTime'];

		$stmt = $conn->prepare("UPDATE $tablename SET Title = ?, Description = ?, PickupTime = ? WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssi",$title,$desc,$pickupTime,$id);
		$stmt->execute();
		$stmt->close();

	}

	else if($_POST['purpose']=="editlistListing"){

		$id = $_POST['id'];
		$listed = $_POST['listed'];

		$stmt = $conn->prepare("UPDATE $tablename SET Listed = ? WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("si",$listed,$id);
		$stmt->execute();
		$stmt->close();

	}

	else if($_POST['purpose']=="deleteListing"){

		$id = $_POST['id'];

		$stmt = $conn->prepare("DELETE FROM $tablename WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$stmt->close();

	}

}

?>