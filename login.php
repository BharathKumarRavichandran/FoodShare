<?php

session_start();
include_once('connect.php');
$_SESSION['message']="";

if($_SERVER["REQUEST_METHOD"]=="POST"){

	$username = trim($_POST['username']);
	$username = stripslashes($username);
	$username = htmlspecialchars($username);
	$username = $conn->real_escape_string($username);

	$password = md5($_POST['password']);

	include_once("createDb.php");

	$stmt = $conn->prepare("SELECT * FROM user WHERE username= ?;");
	if(!$stmt){
		echo "Error preparing statement ".htmlspecialchars($conn->error);
	}
	$stmt->bind_param("s",$username);
	$stmt->execute();
	$result = $stmt->get_result();

	if($result->num_rows>0){
		while($row = $result->fetch_assoc()){

			if($row["password"]==$password){
				$_SESSION["username"] = $username;
				$_SESSION["email"] = $row["email"];
				include("createDataTable.php");
				header("location: home.php");  
			}
			else{
				$_SESSION['message'] = "Sorry, Wrong Password!";
			}
		}
	}	
	else{
		$_SESSION['message'] = "Username doesn't exist!";
	}

	$stmt->close();
		
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Login | FoodShare</title>
	<link rel="icon" type="image/png" href="assets/favicon.png">
	<link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
	<link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
	<a onclick="#"><h1 class="title">FoodShare</h1></a>
    <h2 id="loginTitle">Login</h2>
	<form class="formClass" action="login.php" method="post" autocomplete="off">
	    <div id="errMsg"><?= $_SESSION['message'] ?></div>
	    <div><input id="usernameIn" type="text" placeholder="Username" name="username" required /></div>
		<div><input id="passIn" type="password" placeholder="Password" name="password" required /></div>
	    <div><input id="submitIn" type="submit" value="Login" name="login"/></div>
    </form>
    <div class="options">
    	<span class="text">New User? Register here!</span>
    	<span><button id="signupb" onclick="register()">Sign Up</button></span>
    </div>
    <footer>
		<p id="foot">Made with <span id="heart">&hearts;</span> by <a id="nameLink" href="https://BharathKumarRavichandran.github.io">Bharath Kumar Ravichandran</a></p>
	</footer>
<script>

	function register(){
		window.location = "register.php";
	}

</script>	
</body>
</html>