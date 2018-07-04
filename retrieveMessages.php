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

	if($_POST['purpose']=="retrieveMessages"){

		$username2 = $_POST['username2'];
		$tablename = "chats";

		$stmt = $conn->prepare("SELECT * FROM $tablename WHERE ((Username1=? OR Username1=?) AND (Username2=? OR Username2=?));");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("ssss",$username,$username2,$username,$username2);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();

		$chatData = array();

		if($result->num_rows>0){
			while($row = $result->fetch_assoc()){

				$r = array('Username1'=>$row["Username1"],'Username2'=>$row["Username2"],'Message'=>$row["Message"],'MsgTimeStamp'=>$row["MsgTimeStamp"],'MessageTime'=>$row["MessageTime"],'Status'=>$row["Status"],'CurrentUser'=>$username);
				array_push($chatData,$r);

			}	
		}
		echo json_encode($chatData);
	}
}

?>