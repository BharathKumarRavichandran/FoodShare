<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Profile | FoodShare</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/profile.css">
  	<link rel="stylesheet" type="text/css" href="css/topnav.css">
  	<link rel="stylesheet" type="text/css" href="css/sidenav.css">
  	<link rel="stylesheet" type="text/css" href="css/addListingModal.css">
  	<link rel="stylesheet" type="text/css" href="css/map.css">
  	<link rel="stylesheet" type="text/css" href="css/userBox.css">
  	<link rel="stylesheet" type="text/css" href="css/listingCard.css">
  	<link rel="stylesheet" type="text/css" href="css/usernameChips.css">
</head>

<body>
	<div id="navbar" class="topnav">
		<a id="titleId" class="title" onclick="home()">FoodShare</a>
		<a class="options" href="#home" onclick="home()">Home</a>
	  	<a class="active options" onclick="profile()">Profile</a>
	  	<a class="options" onclick="messages()">Messages</a>
	</div>	
	<div class="sidenav" id="sidenav">
		<a class="sidenavlinks active" onclick="">View Profile</a>
		<a class="sidenavlinks" onclick="openNewListingModal();">Add Listing</a>
		<a id="myListingsId" class="sidenavlinks" onclick="myListings()">My Listings</a>
		<a id="followingId" class="sidenavlinks" onclick="followDataDisplay(this);">Following</a>
		<a id="followersId" class="sidenavlinks" onclick="followDataDisplay(this);">Followers</a>
		<a class="sidenavlinks" onclick="logout();">Logout</a>
	</div>
	<div class="modal" id="modalId"> 
		<div class="modal-content">
			<div class="modal-header">
				<h2 style="text-align: center; font-size: 1.8em; margin-left: 30%; padding: 5px;">Add New Listing</h2>
				<span class="close" id="modalCloseId">&times;</span>
			</div>
			<div class="modal-body">
				<div>
					<select id="modalSelectId">
						<option>Offering</option>
						<option>Wanted</option>
					</select>
				</div>			
				<div><input id="titleInputId" class="inputClass" type="text" name="title" placeholder="Title"/></div>	
				<div><input id="descInputId" class="inputClass" type="text" name="description" placeholder="Description"/></div>	
				<div><input id="locationInputId" class="inputClass" type="text" name="location" placeholder="Approximate Pick-up Address"/></div>
				<input id="pac-input" class="controls" type="text" name="location" placeholder="Locate by place"/>
				<div id="map"></div>
				<div><button id="saveLocationId" onclick="saveLocation();">Save Location</button></div>
				<div><input id="timeInputId" class="inputClass" type="text" name="time" placeholder="Pick-up Times Eg. Monday evening"/></div>	
				<div>Expiry Date: <input id="expiryDateId" type="date" name="expiryDate"></div>
				<div><input id="submitInputId" class="inputClass" type="submit" name="submitList" value="Add" onclick="addListing();"></div>
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
		document.getElementById("titleInputId").value = "";
		document.getElementById("titleInputId").placeholder = "Title";
		document.getElementById("descInputId").value = "";
		document.getElementById("descInputId").placeholder = "Description";
		document.getElementById("timeInputId").value = "";
		document.getElementById("timeInputId").placeholder = "Pick-up Times Eg. Monday evening";
		document.getElementById("expiryDateId").value = new Date().toDateInputValue();
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
<script src="js/profile.js"></script>
<script src="js/generic.js"></script>
<script src="js/createCard.js"></script>
<script src="js/createUserBox.js"></script>
<script src="js/follow.js"></script>
<script src="js/viewProfileClick.js"></script>
</body>
</html>