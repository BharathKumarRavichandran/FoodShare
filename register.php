<?php

session_start();
include_once('connect.php');
include_once("createDb.php");
$_SESSION['message']="";

$tablename = "user";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $sql = "USE FoodShare;";
    $conn->query($sql);

    $_SESSION['message']="";
    $allow=1;

    $url ='https://www.google.com/recaptcha/api/siteverify';
    include_once("config.php");//To include $privateKey variable which contains the secret key to Google reCaptacha's API

    $response = file_get_contents($url."?secret=".$privateKey."&response=".$_POST['g-recaptcha-response']."&remoteip=".$_SERVER['REMOTE_ADDR']);
    $data = json_decode($response);

    if(!((isset($data->success))AND($data->success==true))){
        $_SESSION['message'] = 'Captcha Failed!';
        $allow=0;
    }

    $username = $conn->real_escape_string($_POST['username']);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $_SESSION['message'] = 'Please enter a valid E-Mail address!';
        $allow=0;
    }

    if(!preg_match("/^[a-zA-Z0-9_.-]*$/",$_POST['username'])) {
        $_SESSION['message'] = 'Your username can only contain letters, numbers, underscore, dash, point, no other special characters are allowed!';
        $allow=0;
    }

    $sql = "SELECT * FROM $tablename;";
    $result = $conn->query($sql);

    if($result&&$result->num_rows>0){
        while($row = $result->fetch_assoc()){

            if($row["username"]==$username){
                $_SESSION['message'] = 'Username already exists!';
                $allow=0;
            }

            if($row["email"]==$email){
                $_SESSION['message'] = 'E-Mail already exists!';
                $allow=0;
            }
        }
    }   

    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,}$/",$_POST['password'])) {
        $_SESSION['message'] = 'Your password should contain minimum four characters, at least one letter and one number!';
        $allow=0;
    }


    if($allow==1){

    	//if two passwords are equal to each other
    	if($_POST["password"]==$_POST["confirmpassword"]){

             $sql = "USE FoodShare;";
             $conn->query($sql);

            $password = md5($_POST['password']); //md5 hash password for security

            //set session variables
            $_SESSION['username'] = $username; 
            $_SESSION['email'] = $email;

            include("createDataTable.php");

            //insert user data into database
            $stmt = $conn->prepare("INSERT INTO $tablename (username,email,password) "."VALUES (?,?,?)");
            if(!$stmt){
                echo "Error preparing statement ".htmlspecialchars($conn->error);
            }
            $stmt->bind_param("sss",$username,$email,$password);
            if($stmt->execute() === true){    
                $_SESSION['message'] = "Registration succesful! Added $username to the database!";
                header("location: home.php");  
    		}

            else{
               	$_SESSION['message'] = 'User could not be added to the database!';
            }
            
            $stmt->close();
            $conn->close();   

    	}

    	else{
            $_SESSION['message'] = 'Two passwords do not match!';
        }

    }    

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<title>Sign Up | FoodShare</title>
    <link rel="icon" type="image/png" href="assets/favicon.png">
    <link href='https://fonts.googleapis.com/css?family=Sofia' rel='stylesheet'>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
	<a onclick="#"><h1 class="title">FoodShare</h1></a>
    <h2 id="registerTitle">Sign Up</h2>
    <form action="register.php" method="post" autocomplete="off">
    	<div id="errMsg"><?= $_SESSION['message'] ?><span id="errMsg1"></span></div>
    	<div><input id="usernameIn" type="text" placeholder="Username" name="username" onkeyup="usernameAvailabilty(this.value);" onblur="usernameFocusOut();" required /></div>
	    <div><input id="emailIn" type="email" placeholder="Email" name="email" required /></div>
	    <div><input class="passIn" type="password" placeholder="Password" name="password" required /></div>
	    <div><input class="passIn" type="password" placeholder="Confirm Password" name="confirmpassword" required /></div>
        <div class="reCaptchaClass"><div class="g-recaptcha" data-sitekey="Your-Public-Key"></div></div>
	    <div><input id="submitIn" type="submit" value="Register" name="register"/></div>
    </form>
    <div class="options">
        <span class="text">Already have an account?</span>
        <span><button id="loginb" onclick="login()">Login</button></span>
    </div>
    <footer>
        <p id="foot">Made with <span id="heart">&hearts;</span> by <a id="nameLink" href="https://BharathKumarRavichandran.github.io">Bharath Kumar Ravichandran</a></p>
    </footer>
<script>

    function login(){
        window.location = "login.php";
    }

</script>
<script src="js/register.js"></script>       
</body>
</html>