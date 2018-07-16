<?php

if(session_status()==PHP_SESSION_NONE){
    session_start();
}

include_once("connect.php");

$sql = "USE FoodShare;";
$conn->query($sql);
$username = $_SESSION["username"];

if($_SERVER['REQUEST_METHOD']=="POST"){

	$target_dir = "display_pictures/";
	$fileToUpload = $_FILES["fileToUpload"]["name"];
	$target_file = $target_dir.basename($fileToUpload);
	$uploadOk = 1;
	$errMessage = true;
	$alreadyExists = false;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	}

	if (file_exists($target_file)){
	    $alreadyExists = true;
	}

	if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
	    echo "Sorry, only JPG, JPEG & PNG files are allowed.";
	    $uploadOk = 0;
	}

	if($uploadOk == 0){
	    echo "Sorry, your file was not uploaded.";
	} 

	else{
		if(!$alreadyExists){
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
			}
			else {
		        echo "Sorry, there was an error uploading your file.";
		    }
		}
	    else{
	        $imagePath = $conn->real_escape_string($target_dir.$_FILES['fileToUpload']['name']);

	        $tablename = "user";
        	$stmt = $conn->prepare("UPDATE $tablename SET `DisplayImagePath`=? WHERE username=?; ");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("ss",$imagePath,$username);
			if($stmt->execute() === true){
				$errMessage = false;
			}
			$stmt->close();

			$r = array('ErrorMessage'=>"false","ImagePath"=>urlencode($imagePath));
			echo json_encode($r);

	    } 
	}

	}

?>