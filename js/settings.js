function saveChanges(){

	var newEmail = document.getElementById("newEmail").value;
	var oldPassword = document.getElementById("oldPassword").value;
	var newPassword = document.getElementById("newPassword").value;
	var newConfirmPassword = document.getElementById("newConfirmPassword").value;
	var params = "";

	if(oldPassword==""){
		params = "newEmail="+newEmail;
	}
	else if(oldPassword!=""){
		params = "newEmail="+newEmail+"&oldPassword="+oldPassword+"&newPassword="+newPassword+"&newConfirmPassword="+newConfirmPassword;
	}

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = "credentialsUpdate.php";
	var data;
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			data = JSON.parse(this.responseText);
			document.getElementById("oldPassword").value = "";
			document.getElementById("newPassword").value = "";
			document.getElementById("newConfirmPassword").value = "";

			document.getElementById("alertId").setAttribute("class","alert alert-dismissable "+data.alert);
			document.getElementById("message").innerHTML = data.message;
			document.getElementById("alertId").setAttribute("style","display:block;");
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function changeDisplayPicture(){

	var file = document.getElementById("fileToUpload").files[0];
	var formData = new FormData();
	formData.append('fileToUpload',file);

	$.ajax({

		url:'changeDP.php',
		data:formData,
		processData:false,
		contentType:false,
		type:'POST',
		success:function(msg){
			console.log(msg);

			try{
				imgData = JSON.parse(msg);
				if(imgData.ErrorMessage){
					document.getElementById("alertId").setAttribute("class","alert alert-dismissable alert-success");
					document.getElementById("message").innerHTML = "Profile picture updated successfully!";
					document.getElementById("alertId").setAttribute("style","display:block;");	
					document.getElementById("dp").setAttribute("src",decodeURIComponent(imgData.ImagePath));
				}
			}
			catch(e){
				document.getElementById("alertId").setAttribute("class","alert alert-dismissable alert-danger");
				document.getElementById("message").innerHTML = msg;
				document.getElementById("alertId").setAttribute("style","display:block;");		
			}
			document.getElementById("fileToUpload").value = "";

		}

	});

}

function deleteAccount(){

	var password = document.getElementById("password").value;
	var params = "password="+password;

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = "deleteAccount.php";
	var data;
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			data = JSON.parse(this.responseText);
			if(data.delete == "no"){
				document.getElementById("password").value = "";
				document.getElementById("alertId").setAttribute("class","alert alert-dismissable "+data.alert);
				document.getElementById("message").innerHTML = data.message;
				document.getElementById("alertId").setAttribute("style","display:block;");		
			}
			else if(data.delete == "yes"){
				logout();
			}
			
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}