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
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}