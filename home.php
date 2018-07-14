<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

if(isset($_SESSION["viewUser"])){
	unset($_SESSION["viewUser"]);
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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/home.css">
  	<link rel="stylesheet" type="text/css" href="css/topnav.css">
  	<link rel="stylesheet" type="text/css" href="css/sidenav.css">
  	<link rel="stylesheet" type="text/css" href="css/refineListingModal.css">
  	<link rel="stylesheet" type="text/css" href="css/map.css">
  	<link rel="stylesheet" type="text/css" href="css/searchContainer.css">
  	<link rel="stylesheet" type="text/css" href="css/userBox.css">
  	<link rel="stylesheet" type="text/css" href="css/listingCard.css">
  	<link rel="stylesheet" type="text/css" href="css/usernameChips.css">
  	<link rel="stylesheet" type="text/css" href="css/customButton.css">
</head>

<body>
	<div id="navbar" class="topnav">
		<a class="title" onclick="home()">FoodShare</a>
		<a class="active options" href="#home" onclick="home()">Home</a>
	  	<a class="options" onclick="profile()">Profile</a>
	  	<a class="options" onclick="messages()">Messages</a>
	  	<a class="options" onclick="settings()">Settings</a>
	  	<span class="search-container">
	      	<input id="searchValue" type="text" placeholder="Search User" name="search" />
	      	<button id="searchButtonId" onclick="searchUser()"><i class="fa fa-search"></i></button>	
	  	</span>
	</div>	
	<div class="sidenav" id="sidenav">
		<a id="browseId" class="sidenavlinks active" onclick="browseListings()">Browse Listings</a>
		<a id="refineId" class="sidenavlinks" onclick="openRefineListingModal()">Refine Listings</a>
		<a class="sidenavlinks" onclick="logout();">Logout</a>
	</div>
	<div class="modal" id="modalId"> 
		<div class="modal-content">
			<div class="modal-header">
				<h2 style="text-align: center; font-size: 1.8em; margin-left: 30%; padding: 5px;">Refine results by:</h2>
				<span class="close" id="modalCloseId">&times;</span>
			</div>
			<div class="modal-body">
				<div class="typeRefine"><span>Type : </span>
					<select id="modalSelectId1">
						<option>Offering</option>
						<option>Wanted</option>
					</select>
				</div>
				<input id="pac-input" class="controls" type="text" name="location" placeholder="Locate by place"/>
				<div id="map"></div>
				<div class="distanceRefine"><span>Show results within : </span>
					<select id="modalSelectId2">
						<option>&lt;10KM</option>
						<option>10KM - 30KM</option>
						<option>30KM - 100KM</option>
						<option>All Listings</option>
					</select>
				</div>
				<div class="form-group"><input id="submitInputId" class="btn btn-custom form-control" type="submit" name="refineList" value="Refine" onclick="refineListings();"></div>
			</div>
		</div>
	</div>
	<div id="listingRegion" class="main" style="margin-top: 20vh;"></div>

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

	var modal = document.getElementById('modalId');
	var close = document.getElementById("modalCloseId");

	close.onclick = function() {
	    modal.style.display = "none";  
	}

	window.onclick = function(event) {
	    if (event.target == modal) {
	        modal.style.display = "none";
	    }
	}	

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCLayRaJZWWbmSToJZd9UHgwp5QNVme5gw&libraries=places&callback=initAutocomplete" async defer></script>
<script src="js/config.js"></script>
<script src="js/map.js"></script>
<script src="js/functions.js"></script>
<script src="js/home.js"></script>
<script src="js/generic.js"></script>
<script src="js/createCard.js"></script>
<script src="js/createUserBox.js"></script>
<script src="js/follow.js"></script>
<script src="js/viewProfileClick.js"></script>
</body>
</html>