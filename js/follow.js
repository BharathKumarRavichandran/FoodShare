function followBtnClick(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("followBtn");
    var k = parseInt(res[1]);
    var click;
    click = y.innerHTML;

    if(y.innerHTML=="Follow"){
    	y.innerHTML = "Following";
    } 
    else if(y.innerHTML=="Following"){
		y.innerHTML = "Follow";
    }
    else if(y.innerHTML=="View Profile"){
    	window.location = "profile.php";
    }

    var followUsername = document.getElementById("username"+k).innerHTML;
    var purpose = "followBtnClick";

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params = "followUsername="+followUsername+"&click="+click+"&purpose="+purpose;
	var url = "followUser.php";
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	console.log(this.responseText);
	    }
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}