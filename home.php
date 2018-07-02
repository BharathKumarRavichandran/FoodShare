<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

$_SESSION['message']="";

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Home | FoodShare</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/home.css">
  	<link rel="stylesheet" type="text/css" href="css/topnav.css">
  	<link rel="stylesheet" type="text/css" href="css/sidenav.css">
</head>

<body>
	<div id="navbar" class="topnav">
		<a class="title" onclick="home()">FoodShare</a>
		<a class="active options" href="#home" onclick="home()">Home</a>
	  	<a class="options" onclick="profile()">Profile</a>
	</div>	
	<div class="sidenav" id="sidenav">
		<a id="activityId" class="sidenavlinks active" onclick="">Browse Listings</a>
		<a class="sidenavlinks" onclick="logout();">Logout</a>
	</div>
	<div id="activityRegion" class="main" style="margin-top: 20vh;"></div>

<script type="text/javascript">

	document.getElementById("sidenav").style.top = document.getElementById("navbar").offsetHeight+"px";

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
<script src="js/home.js"></script>
</body>
</html>