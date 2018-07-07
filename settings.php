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

$_SESSION['message'] = "NOTE : Username cannot be changed !";

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Settings | FoodShare</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/topnav.css">
</head>

<body>
	<div id="navbar" class="topnav">
		<a id="titleId" class="title" onclick="home()">FoodShare</a>
		<a class="options" href="#home" onclick="home()">Home</a>
	  	<a class="options" onclick="profile()">Profile</a>
	  	<a class="options" onclick="messages()">Messages</a>
	  	<a class="active options" onclick="settings()">Settings</a>
	</div>	
	<div style="margin-top: 3vh;">
		<div class="container">
		    <h1>Edit Profile</h1>
		  	<hr>
	<!----------------------------------------------->
			<div class="row">
			<!----------------------------------------------->
		      <div class="col-md-3">
		        <div class="text-center">
		          <img src="//placehold.it/100" class="avatar img-circle" alt="avatar">
		          <h6>Upload a different photo...</h6>          
		          <input type="file" class="form-control">
		        </div>
		      </div>
		    <!----------------------------------------------->  
		      <div class="col-md-9 personal-info">

		        <div id="alertId" class="alert alert-info alert-dismissable">
			        <a class="panel-close close" data-dismiss="alert">×</a> 
			        <div id="message"><?= $_SESSION['message']; ?></div>
		        </div>

 				<!----------------------------------------------->
		        <h3>Personal info</h3>

		        <form class="form-horizontal" role="form">

		        	<div class="form-group">
		        		<div class="row">
				            <label class="col-md-3 control-label">Username:</label>
				            <div class="col-md-8">
				              	<input class="form-control" type="text" value="<?= $_SESSION['username']; ?>" disabled>
				            </div>
			            </div>
		         	 </div>

		          	<div class="form-group">
		          		<div class="row">
				            <label class="col-lg-3 control-label" for="newEmail">Email:</label>
				            <div class="col-lg-8">
				              	<input id="newEmail" class="form-control" type="text" name="newEmail" value="<?= $_SESSION['email']; ?>">
				            </div>
				        </div>    
		         	 </div>

		          	<div class="form-group">
		          		<div class="row">
				            <label class="col-md-3 control-label" for="oldPassword">Old Password:</label>
				            <div class="col-md-8">
				              	<input id="oldPassword" class="form-control" type="password" name="oldPassword" placeholder="Enter Old Password">
				            </div>
				        </div>    
		         	 </div>

		          	<div class="form-group">
		          		<div class="row">
				            <label class="col-md-3 control-label" for="newPassword">Password:</label>
				            <div class="col-md-8">
				            	<input id="newPassword" class="form-control" type="password" name="newPassword" placeholder="Enter New Password">
				            </div>
				        </div>    
		         	 </div>

		          	<div class="form-group">
		          		<div class="row">
				            <label class="col-md-3 control-label" for="newConfirmPassword">Confirm password:</label>
				            <div class="col-md-8">
				              	<input id="newConfirmPassword" class="form-control" type="password" name="newConfirmPassword" placeholder="Retype New Password">
				            </div>
				        </div>
		          	</div>

		          	<div class="form-group">
		          		<div class="row">
				            <label class="col-md-3 control-label"></label>
				            <div class="col-md-8">
				            	<input type="button" class="btn btn-primary" value="Save Changes" onclick="saveChanges()">
				            </div>
				        </div>    
		         	 </div>

		        </form>

		      </div>
		  </div>
		</div>
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
<script src="js/settings.js"></script>
<script src="js/functions.js"></script>
</body>
</html>