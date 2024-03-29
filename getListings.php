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

		$tablename2 = "user";
		$imagePathSelf = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename2 WHERE username = ?");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePathSelf = $dpPath;
		}
		$stmt->close();

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

				$r = array('listingId'=>$row["id"],'Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"],'Listed'=>$row["Listed"],'ImgPath'=>$row['ImgPath'],'dpPath'=>$imagePathSelf);
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

		$tablename2 = "user";
		$imagePath = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename2 WHERE username = ?");
		$stmt->bind_param("s",$viewUser);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePath = $dpPath;
		}
		$stmt->close();

		$listingsData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				if($row["Listed"]=="yes"){

					$r = array('listingId'=>$row["id"],'Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"],'Listed'=>$row["Listed"],'ImgPath'=>$row['ImgPath'],'dpPath'=>$imagePath);
					array_push($listingsData,$r);	

				}
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

				if($row["Listed"]=="yes"){

					$tablename2 = "user";
					$imagePath = "";
					$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename2 WHERE username = ?");
					$stmt->bind_param("s",$row["Username"]);
					$stmt->execute();
					$stmt->bind_result($dpPath);
					while($stmt->fetch()){
					    $imagePath = $dpPath;
					}
					$stmt->close();

					$r = array('listingId'=>$row["id"],'Username'=>$row["Username"],'Type'=>$row["Type"],'Title'=>$row["Title"],'Description'=>$row["Description"],'Address'=>$row["Address"],'Latitude'=>$row["Latitude"],'Longitude'=>$row["Longitude"],'PickupTime'=>$row["PickupTime"],'ExpiryDate'=>$row["ExpiryDate"],'CreationTime'=>$row["CreationTime"],'Listed'=>$row["Listed"],'ImgPath'=>$row['ImgPath'],'dpPath'=>$imagePath);
					array_push($listingsData,$r);	

				}
					
			}
		}	
		echo json_encode($listingsData);

	}

	
}

?>