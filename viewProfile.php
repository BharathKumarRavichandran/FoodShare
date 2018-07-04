<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

if(!isset($_SESSION["viewUser"])){
	header('Location: home.php');
	exit();
}

$username = $_SESSION['username'];
$viewUser = $_SESSION['viewUser'];
$tablename = "user";

$sql = "USE FoodShare;";
$conn->query($sql);

$stmt = $conn->prepare("SELECT Following FROM $tablename WHERE username = ?;");
if(!$stmt){
	echo "Error preparing statement ".htmlspecialchars($conn->error);
}
	$stmt->bind_param("s",$username);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();

	$array = array();
	$followValue;

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			$array = explode(",",$row["Following"]);
			for($i=0;$i<count($array);$i++){

				if($array[$i]==$viewUser){
					$followValue = "Following";
					break;
				}
				else if($viewUser==$username){
					$followValue = "View Profile";
				}
				else if($array[$i]!=$viewUser){
					$followValue = "Follow";
				}

			}
		}
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>View Profile | Revivify</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/viewProfile.css">
	<link rel="stylesheet" type="text/css" href="css/topnav.css">

</head>
<body>
	<div id="navbar" class="topnav">
		<a class="title" onclick="home()">FoodShare</a>
		<a class="options" href="#home" onclick="home()">Home</a>
	  	<a class="options" onclick="profile()">Profile</a>
	  	<a class="options" onclick="messages()">Messages</a>
	</div>
	<div>
		<div id="viewUser" class="userDispBig"><?= $viewUser ?></div>
		<div style="text-align: center;"><button id="followBtn" class="userBtn btn btn-brown" onclick="followBtnClick(this)"><?= $followValue ?></button></div>
		<div class="recentText">User's Recent Activity</div>
		<div id="activityRegion"></div>
	</div>	
<script type="text/javascript">

	window.onscroll = function() {myFunction()};

	var navbar = document.getElementById("navbar");

	var sticky = navbar.offsetTop;

	function myFunction() {
		if (window.pageYOffset >= sticky) {
		    navbar.classList.add("sticky")
		} 
		else{
		    navbar.classList.remove("sticky");
		 }
	}

</script>	
<script src="js/functions.js"></script>
<script src="js/viewProfile.js"></script>
<script src="js/viewProfileClick.js"></script>
</body>
</html>