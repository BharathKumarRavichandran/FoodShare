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
	<title>Messages | FoodShare</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  	<link rel="stylesheet" type="text/css" href="css/topnav.css">
  	<link rel="stylesheet" type="text/css" href="css/sidenav.css">
  	<link rel="stylesheet" type="text/css" href="css/messages.css">
  	<link rel="stylesheet" type="text/css" href="css/message.css">
</head>

<body>
	<div id="navbar" class="topnav">
		<a class="title" onclick="home()">FoodShare</a>
		<a class="options" href="#home" onclick="home()">Home</a>
	  	<a class="options" onclick="profile()">Profile</a>
	  	<a class="options active" onclick="messages()">Messages</a>
	</div>	
	<div class="sidenav" id="sidenav">
		<a class="sidenavlinks" onclick="logout();">Logout</a>
	</div>
	<div id="chatRegion">
	</div>
	<input id="chatInput" class="chatInput" type="text" name="send">

<script type="text/javascript">

	/*--------------Function to get the current style value by feeding element-id(el) and property(styleProp)--------------*/
	function getStyle(el,styleProp){
	    var x = document.getElementById(el);
	    if (x.currentStyle)
	        var y = x.currentStyle[styleProp];
	    else if (window.getComputedStyle)
	        var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
	    return y;
	}

	document.getElementById("sidenav").style.top = document.getElementById("navbar").offsetHeight+"px";
	document.getElementById("chatRegion").style.marginLeft = document.getElementById("sidenav").width+"px";
	document.getElementById("chatRegion").style.height = (screen.height - document.getElementById("navbar").offsetHeight - document.getElementById("chatInput").offsetHeight - parseInt(getStyle("chatRegion","margin-top"),10)-70)+"px";

/*---- For navbar onscroll----*/
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
<script src="js/config.js"></script>
<script src="js/functions.js"></script>
<script src="js/messages.js"></script>
<script src="js/addMessage.js"></script>
</body>
</html>