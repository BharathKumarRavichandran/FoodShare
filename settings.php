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

$username = $_SESSION["username"];

$tablename = "user";
$imagePath = "display_pictures/default_dp.jpg";
$stmt = $conn->prepare("SELECT `DisplayImagePath` FROM $tablename WHERE username = ?");
$stmt->bind_param("s",$username);
$stmt->execute();
$stmt->bind_result($dpPath);
while($stmt->fetch()){
    $imagePath = $dpPath;
}
$stmt->close();

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
  	<link rel="stylesheet" type="text/css" href="css/customButton.css">
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
		          <img id="dp" src="<?= $imagePath ?>" onError="this.onerror=null;this.src='display_pictures/default_dp.jpg';" class="avatar img-circle" alt="avatar" style="width: 100px; height: 100px;">
		          <h6>Upload a different photo...</h6>          
		          <input id="fileToUpload" type="file" class="form-control" name="fileToUpload" accept="image/*">
		        </div>
		        <div class="row">
			        <div class="col-md-2"></div>
			        <div class="col-md-10" style="margin-top: 18px;">
			       		<button class="btn btn-primary" onclick="changeDisplayPicture();">Update Profile Picture</button>
			       	</div>
			    </div>   		
		      </div>
		    <!----------------------------------------------->  
		      <div class="col-md-9 personal-info">

		        <div id="alertId" class="alert alert-info alert-dismissable" style="display: none;">
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
				            	<input type="button" class="btn btn-custom" value="Save Changes" onclick="saveChanges()">
				            </div>
				        </div>    
		         	</div>

					<hr>

		         	<div class="form-group" style="margin-top: 0px;">
		          		<div class="row">
				            <label class="col-md-3 control-label" style="font-size: 20px;">Delete Account</label>
				            <div class="col-md-8" style="margin-top: 10px; font-size: 15px;">
				            	<div>Are you sure to delete your account and all information related to your account? Please be aware that all data will be permanently lost if you delete your account.</div>
				            </div>
				        </div>    
		            	<div class="row">
		            		<div class="col-md-3"></div>
			            	<div class="form-group" style="margin-top: 10px; margin-left: 2px;">
						            <div class="col-md-10">
						            	<input id="password" class="form-control" type="password" name="password" placeholder="Enter Password">
						            </div>
						            <div class="col-md-0"></div>
						        </div>    
				         	 </div>
			         	 </div>
			         	<div class="col-md-3"></div>
			         	<div class="col-md-9">
		              		<input type="button" class="btn btn-danger" value="Delete Account" onclick="deleteAccount()" style="margin-left: -10px;">
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