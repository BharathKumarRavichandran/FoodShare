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

	if($_POST['purpose']=="saveMessage"){

		$username2 = $_POST['username2'];
		$message = $_POST['message'];
		$msgTimeStamp = $_POST['msgTimeStamp'];
		$messageTime = date('Y-m-d H:i:s');

		$tablename = "chats";

		$stmt = $conn->prepare("INSERT INTO $tablename(Username1,Username2,Message,MsgTimeStamp,MessageTime) VALUES(?,?,?,?,?);");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssss",$username,$username2,$message,$msgTimeStamp,$messageTime);
		$stmt->execute();
		$stmt->close();

		$tablename = "totalChats";
		$totalMessages = 1;

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE ((Username1=? OR Username1=?) AND (Username2=? OR Username2=?));");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("ssss",$username,$username2,$username,$username2);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$totalMessages = $row["TotalMessages"]+1;

				$stmt = $conn->prepare("UPDATE $tablename SET TotalMessages=?;");
				if(!$stmt){
					echo "Error preparing statement ".htmlspecialchars($conn->error);
				}
				$stmt->bind_param("i",$totalMessages);
				$stmt->execute();
				$stmt->close();

			}	
		}

		else{

			$stmt = $conn->prepare("INSERT INTO $tablename(Username1,Username2,TotalMessages) VALUES(?,?,?);");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ssi",$username,$username2,$totalMessages);
			$stmt->execute();
			$stmt->close();

		}
		

	}

}

?>