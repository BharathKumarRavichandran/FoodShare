<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

$_SESSION['message']="";
$username =$_SESSION['username'];

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	if($_POST['purpose']=="retrieveSeenMessages"){

		$username2 = $_POST['username2'];

		$tablename = "user";
		$imagePathSelf = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename WHERE username = ?");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePathSelf = $dpPath;
		}
		$stmt->close();

		$tablename = "user";
		$imagePathOther = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename WHERE username = ?");
		$stmt->bind_param("s",$username2);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePathOther = $dpPath;
		}
		$stmt->close();

		$tablename = "chats";
		$status = "seen";

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE ((Username1=? OR Username1=?) AND (Username2=? OR Username2=?)) AND Status = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssss",$username,$username2,$username,$username2,$status);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$chatData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$r = array('Username1'=>$row["Username1"],'Username2'=>$row["Username2"],'Message'=>$row["Message"],'MsgTimeStamp'=>$row["MsgTimeStamp"],'MessageTime'=>$row["MessageTime"],'Status'=>$row["Status"],'CurrentUser'=>$username,'imagePathSelf'=>$imagePathSelf,'imagePathOther'=>$imagePathOther);
				array_push($chatData,$r);

			}	
		}
		echo json_encode($chatData);
	}

	if($_POST['purpose']=="retrieveUnseenMessages"){

		$username2 = $_POST['username2'];

		$tablename = "user";
		$imagePathSelf = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename WHERE username = ?");
		$stmt->bind_param("s",$username);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePathSelf = $dpPath;
		}
		$stmt->close();

		$tablename = "user";
		$imagePathOther = "";
		$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename WHERE username = ?");
		$stmt->bind_param("s",$username2);
		$stmt->execute();
		$stmt->bind_result($dpPath);
		while($stmt->fetch()){
		    $imagePathOther = $dpPath;
		}
		$stmt->close();
		
		$tablename = "chats";
		$status = "unseen";

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE ((Username1=? OR Username1=?) AND (Username2=? OR Username2=?)) AND Status = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssss",$username,$username2,$username,$username2,$status);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$chatData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				if($row["Username2"]==$username){
					$status = "seen";
					$sql = "UPDATE $tablename SET Status='$status' WHERE id=".$row['id'].";";
					$conn->query($sql);
				}	

				$r = array('Username1'=>$row["Username1"],'Username2'=>$row["Username2"],'Message'=>$row["Message"],'MsgTimeStamp'=>$row["MsgTimeStamp"],'MessageTime'=>$row["MessageTime"],'Status'=>$row["Status"],'CurrentUser'=>$username,'imagePathSelf'=>$imagePathSelf,'imagePathOther'=>$imagePathOther);
				array_push($chatData,$r);

			}	
		}
		echo json_encode($chatData);
	}
}

?>