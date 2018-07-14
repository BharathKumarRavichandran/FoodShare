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
    $imagePath = "display_pictures/default_dp.jpg";
    $allow=1;
    $alreadyExists = false;
    $uploadOk = 1;

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

    function dp_uploaded(){

        if(empty($_FILES["fileToUpload"]["name"])){
            return false;
        }
        else{
            return true;
        }

    }

    $dpUploaded = dp_uploaded();

    if($dpUploaded){

        $target_dir = "display_pictures/";
        $fileToUpload = $_FILES["fileToUpload"]["name"];
        $target_file = $target_dir.basename($fileToUpload);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        if(isset($_POST["submit"])){
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                $_SESSION["message"] = "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            }
            else{
                $_SESSION["message"] = "File is not an image.";
                $uploadOk = 0;
            }
        }

        if(file_exists($target_file)){
            $alreadyExists = true;
        }

        if($_FILES["fileToUpload"]["size"] > 500000){
            $_SESSION["message"] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
            $_SESSION["message"] = "Sorry, only JPG, JPEG & PNG files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0){
            $_SESSION["message"] = "Sorry, your file was not uploaded.";
        } 

        else{
            if(!$alreadyExists){
                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                    $_SESSION["message"] =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                    $imagePath = $conn->real_escape_string($target_dir.$_FILES['fileToUpload']['name'].' ');
                }
                else{
                    $_SESSION["message"] = "Sorry, there was an error uploading your file.";
                }
            }
            else{
                $_SESSION["message"] =  "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
                $imagePath = $conn->real_escape_string($target_dir.$_FILES['fileToUpload']['name'].' ');
                $_SESSION["message"] = $imagePath;
            } 
        }

    }

    if(($allow==1)&&($uploadOk==1)){

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
            $stmt = $conn->prepare("INSERT INTO $tablename (username,email,password,DisplayImagePath) VALUES(?,?,?,?)");
            if(!$stmt){
                echo "Error preparing statement ".htmlspecialchars($conn->error);
            }
            $stmt->bind_param("ssss",$username,$email,$password,$imagePath);
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/register.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/customButton.css">
</head>
<body>
	<a onclick="#" style="text-decoration: none; color: black;"><h1 class="title">FoodShare</h1></a>
    <h2 id="registerTitle">Sign Up</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <div class="text-center">
                    <form action="register.php" method="post" enctype="multipart/form-data" autocomplete="off">
                        <div id="errMsg"><?= $_SESSION['message'] ?><span id="errMsg1"></span></div>
                        <div class="form-group"><input id="usernameIn" class="form-control" type="text" placeholder="Username" name="username" onkeyup="usernameAvailabilty(this.value);" onblur="usernameFocusOut();" required /></div>
                        <div class="form-group"><input id="emailIn" class="form-control" type="email" placeholder="Email" name="email" required /></div>
                        <div class="form-group"><input class="passIn form-control" type="password" placeholder="Password" name="password" required /></div>
                        <div class="form-group"><input class="passIn form-control" type="password" placeholder="Confirm Password" name="confirmpassword" required /></div>
                        <div class="form-group">
                            <label class="control-label" for="fileToUpload">Upload Profile Picture (optional)</label>
                            <input id="fileToUpload" class="form-control" type="file" class="form-control" name="fileToUpload" accept="image/*">
                        </div>
                        <div class="reCaptchaClass"><div class="g-recaptcha" data-sitekey="Your-Public-Key"></div></div>
                        <div class="form-group"><input id="submitIn" class="form-control btn btn-custom" type="submit" value="Register" name="register"/></div>
                    </form>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>          
    </div>
    <div class="options">
        <span class="text">Already have an account?</span>
        <span><button id="loginb" class="btn btn-custom" onclick="login()">Login</button></span>
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