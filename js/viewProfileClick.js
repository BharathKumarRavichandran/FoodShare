function viewProfileBtnClick(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("viewProfileBtn");
    var k = parseInt(res[1]);
    var viewUser = document.getElementById("username"+k).innerHTML;

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var data;
	var url = "setViewUser.php?viewUser="+viewUser;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	console.log(this.responseText); 
	    	window.location = "viewProfile.php";
	    }
	};
	xmlhttp.open("GET",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send();

}