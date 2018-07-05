<?php

//File that gets all listings data from database
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
$tablename = "foods";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	if($_POST["purpose"]=="self"){

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE Username = ?");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$listingsData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$r = array('Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"]);
				array_push($listingsData,$r);	
			}
		}	
		echo json_encode($listingsData);

	}

	else if($_POST["purpose"]=="others"){

		$viewUser = $_SESSION["viewUser"];

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE Username = ?");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("s",$viewUser);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$listingsData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$r = array('Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"]);
				array_push($listingsData,$r);	
			}
		}	
		echo json_encode($listingsData);

	}

	else if($_POST["purpose"]=="all"){

		$stmt = $conn->prepare("SELECT * FROM $tablename");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$listingsData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$r = array('Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"]);
				array_push($listingsData,$r);	
			}
		}	
		echo json_encode($listingsData);

	}

	
}

?>