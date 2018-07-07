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
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/login.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/customButton.css">
</head>
<body>
	<a onclick="#" style="text-decoration: none; color: black;"><h1 class="title">FoodShare</h1></a>
    <h2 id="loginTitle">Login</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="text-center">
                    <form class="formClass" action="login.php" method="post" autocomplete="off">
					    <div id="errMsg"><?= $_SESSION['message'] ?></div>
					    <div class="form-group"><input id="usernameIn" class="form-control" type="text" placeholder="Username" name="username" required /></div>
						<div class="form-group"><input id="passIn" class="form-control" type="password" placeholder="Password" name="password" required /></div>
					    <div class="form-group"><input id="submitIn" class="form-control btn btn-custom" type="submit" value="Login" name="login"/></div>
				    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>          
    </div>
    <div class="options">
    	<span class="text">New User? Register here!</span>
    	<span><button id="signupb" class="btn btn-custom" onclick="register()">Sign Up</button></span>
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