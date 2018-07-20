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


$tablename = "user";
$username = $_SESSION['username'];
$alert = "alert-info";
$display = "";

if($_SERVER["REQUEST_METHOD"]=="POST"){

    $sql = "USE FoodShare;";
    $conn->query($sql);

    $allow=1;

	if((empty($_POST["newPassword"]))&&(empty($_POST["newConfirmPassword"]))&&(empty($_POST["oldPassword"]))){

		$email = $_POST['newEmail'];
	    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

	    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	        $_SESSION['message'] = 'Please enter a valid E-Mail address!';
	        $alert = "alert-danger";
	        $display = "block";
	        $allow=0;
	    } 

	    if(($allow==1)&&($_SESSION['email']!=$email)){

	    	 $_SESSION['email'] = $email;

            //update user email in database
            $stmt = $conn->prepare("UPDATE $tablename SET email = ? WHERE username=? ;");
            if(!$stmt){
                echo "Error preparing statement ".htmlspecialchars($conn->error);
            }
            $stmt->bind_param("ss",$email,$username);
            if($stmt->execute() === true){    
                $_SESSION['message'] = "Changes saved!";
                $alert = "alert-success";
                $display = "block";
    		}
            else{
               	$_SESSION['message'] = 'Sorry, User email cannot be updated!';
               	$alert = "alert-danger";
               	$display = "block";
            }     
            $stmt->close();
            $conn->close();  

	    }	

	}

    else if(((!empty($_POST["newPassword"]))&&(!empty($_POST["newConfirmPassword"]))&&(!empty($_POST["oldPassword"])))){

    	$stmt = $conn->prepare("SELECT * FROM $tablename WHERE username=? ;");
        if(!$stmt){
            echo "Error preparing statement ".htmlspecialchars($conn->error);
        }
        $stmt->bind_param("s",$username);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $oldPassword = md5($_POST["oldPassword"]);

        if($result->num_rows>0){
			while($row = $result->fetch_assoc()){
				if($oldPassword!=$row['password']){
					$_SESSION['message'] = 'Your Password is incorrect!';
			        $alert = "alert-danger";
			        $display = "block";
			        $allow=0;
				}
			}
		}

	    $email = $_POST['newEmail'];
	    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

	    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	        $_SESSION['message'] = 'Please enter a valid E-Mail address!';
	        $alert = "alert-danger";
	        $display = "block";
	        $allow=0;
	    } 

	    if(!preg_match("/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{4,}$/",$_POST['newPassword'])) {
	        $_SESSION['message'] = 'Your password should contain minimum four characters, at least one letter and one number!';
	        $alert = "alert-danger";
	        $display = "block";
	        $allow=0;
	    }


	    if($allow==1){

	    	//if two passwords are equal to each other
	    	if($_POST["newPassword"]==$_POST["newConfirmPassword"]){

	            $password = md5($_POST['newPassword']); //md5 hash password for security

	            //set session variables
	            $_SESSION['email'] = $email;

	            //update user data in database
	            $stmt = $conn->prepare("UPDATE $tablename SET email = ?,password = ? WHERE username=? ;");
	            if(!$stmt){
	                echo "Error preparing statement ".htmlspecialchars($conn->error);
	            }
	            $stmt->bind_param("sss",$email,$password,$username);
	            if($stmt->execute() === true){    
	                $_SESSION['message'] = "Changes saved!";
	                $alert = "alert-success";
	                $display = "block"; 
	    		}
	            else{
	               	$_SESSION['message'] = 'Sorry, User profile cannot be updated!';
	               	$alert = "alert-danger";
	               	$display = "block";
	            }     
	            $stmt->close();
	            $conn->close();   

	    	}

	    	else{
	            $_SESSION['message'] = 'Two passwords do not match!';
	            $alert = "alert-danger";
	            $display = "block";
	        }

	    }    
	}
	$r = array('alert'=>$alert,'message'=>$_SESSION['message']);
	echo json_encode($r);
}

?>