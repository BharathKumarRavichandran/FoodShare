<?php

session_start();
include_once("connect.php");

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

	$sql = "Use Foodshare";
	$conn->query($sql);

	$stmt = $conn->prepare("SELECT * FROM $tablename WHERE username=? ;");
    if(!$stmt){
        echo "Error preparing statement ".htmlspecialchars($conn->error);
    }
    $stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    $password = md5($_POST["password"]);

    if($result->num_rows>0){
		while($row = $result->fetch_assoc()){
			if($password!=$row['password']){
				$_SESSION['message'] = 'Your Password is incorrect!';
		        $alert = "alert-danger";
		        $display = "block";
		        $allow=0;
		        $r = array('delete'=>'no','alert'=>$alert,'message'=>$_SESSION['message']);
				echo json_encode($r);
			}
			else if($password == $row['password']){

				$stmt = $conn->prepare("DELETE FROM $tablename WHERE username=? ;");
			    if(!$stmt){
			        echo "Error preparing statement ".htmlspecialchars($conn->error);
			    }
			    $stmt->bind_param("s",$username);
			    if($stmt->execute() === TRUE){

			    	$delUser = $username.",";

			    	$stmt = $conn->prepare("UPDATE $tablename SET Followers= REPLACE(Followers,?,''), Following= REPLACE(Following,?,'');");
					if(!$stmt){
						echo "Error preparing statement ".htmlspecialchars($conn->error);
					}
					$stmt->bind_param("ss",$delUser,$delUser);
					$stmt->execute();

			    	$r = array('delete'=>'yes');
					echo json_encode($r);
				}
			    $stmt->close();

			}
		}
	}	

}

?>