<?php

//File that gets user's following and followers data of current user from database
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
$tablename = "user";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	$userSearchValue = $_POST["userSearchValue"];
	$userSearchValue.="%";

	$stmt = $conn->prepare("SELECT * FROM $tablename WHERE username LIKE ?;");
	if(!$stmt){
		echo "Error preparing statement ".htmlspecialchars($conn->error);
	}
	$stmt->bind_param("s",$userSearchValue);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$userData = array();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			$currUser = $username.",";

			if((strpos($row["Following"],$currUser)!==false)||(strpos($row["Followers"],$currUser)!==false)){

				$r = array('Username'=>$row["username"]);
				array_push($userData,$r);

			}

		}
	}
	echo json_encode($userData);
		
}

?>