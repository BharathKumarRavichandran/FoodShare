<?php

session_start();
include_once("connect.php");
include_once("createDataTable.php");

if(!isset($_SESSION["username"])){
	header('Location: login.php');
	exit();
}

$_SESSION['message'] = "";

$username = $_SESSION['username'];
$tablename = "foods";

if($_SERVER['REQUEST_METHOD']=="POST"){

	$sql = "USE FoodShare;";
	$conn->query($sql);

	if($_POST['purpose']=="addListing"){

		$type = $_POST['type'];
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$address = $_POST['address'];
		$latitude = $_POST['latitude'];
		$longitude = $_POST['longitude'];
		$pickupTime = $_POST['time'];
		$expiryDate = $_POST['expiryDate'];
		$creationDate = date('Y-m-d H:i:s');

		if(!isset($_SESSION['upload'])){

			$stmt = $conn->prepare("INSERT INTO $tablename(Username,Type,Title,Description,Address,Latitude,Longitude,PickupTime,ExpiryDate,CreationTime) VALUES(?,?,?,?,?,?,?,?,?,?);");
			if(!$stmt){
				echo "Error preparing statement ".htmlspecialchars($conn->error);
			}
			$stmt->bind_param("sssssddsss",$username,$type,$title,$desc,$address,$latitude,$longitude,$pickupTime,$expiryDate,$creationDate);
			$stmt->execute();
			$stmt->close();

		}

		if(isset($_SESSION['upload'])){

			if(!($_FILES["fileToUpload"]["error"]==4)){

				$target_dir = "uploads/";
				$fileToUpload = $_FILES["fileToUpload"]["name"];
				$target_file = $target_dir.basename($fileToUpload);
				$uploadOk = 1;
				$alreadyExists = false;
				$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

				if(isset($_POST["submit"])) {
				    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
				    if($check !== false) {
				        $_SESSION['message']="File is an image - " . $check["mime"] . ".";
				        $uploadOk = 1;
				    } else {
				        $_SESSION['message']="File is not an image.";
				        $uploadOk = 0;
				    }
				}

				if (file_exists($target_file)) {
				    $alreadyExists = true;
				}

				if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
				&& $imageFileType != "gif" ) {
				    $_SESSION['message']="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				    $uploadOk = 0;
				}

				if ($uploadOk == 0) {
				    $_SESSION['message']="Sorry, your file was not uploaded.";
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
				        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
				        $imagePath = $conn->real_escape_string('uploads/'.$_FILES['fileToUpload']['name'].' ');

				        $stmt = $conn->prepare("INSERT INTO $tablename(Username,Type,Title,Description,Address,Latitude,Longitude,PickupTime,ExpiryDate,CreationTime,ImgPath) VALUES(?,?,?,?,?,?,?,?,?,?,?);");
						if(!$stmt){
							echo "Error preparing statement ".htmlspecialchars($conn->error);
						}
						$stmt->bind_param("sssssddssss",$username,$type,$title,$desc,$address,$latitude,$longitude,$pickupTime,$expiryDate,$creationDate,$imagePath);
						$stmt->execute();
						$stmt->close();

				    } 
				}
			}
			unset($_SESSION['upload']);
		}	

	}

	else if($_POST['purpose']=="editListing"){

		$id = $_POST['id'];
		$title = $_POST['title'];
		$desc = $_POST['desc'];
		$pickupTime = $_POST['pickupTime'];

		$stmt = $conn->prepare("UPDATE $tablename SET Title = ?, Description = ?, PickupTime = ? WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("sssi",$title,$desc,$pickupTime,$id);
		$stmt->execute();
		$stmt->close();

	}

	else if($_POST['purpose']=="editlistListing"){

		$id = $_POST['id'];
		$listed = $_POST['listed'];

		$stmt = $conn->prepare("UPDATE $tablename SET Listed = ? WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("si",$listed,$id);
		$stmt->execute();
		$stmt->close();

	}

	else if($_POST['purpose']=="deleteListing"){

		$id = $_POST['id'];

		$stmt = $conn->prepare("DELETE FROM $tablename WHERE id = ?;");
		if(!$stmt){
			echo "Error preparing statement ".htmlspecialchars($conn->error);
		}
		$stmt->bind_param("i",$id);
		$stmt->execute();
		$stmt->close();

	}

}

?>