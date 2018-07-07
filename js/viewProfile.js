var listingRegion = document.getElementById("listingRegion");

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

    var followUsername = document.getElementById("viewUser").innerHTML;
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
	    	messageBtnAppend();
	    }
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function messageBtnAppend(){

	var isfollowing = document.getElementById("followBtn").innerHTML;
	
	if(isfollowing=="Following"){
		var button = document.createElement("button");
		var text = document.createTextNode("Message");

		button.appendChild(text);
		document.getElementById("btnRegion").appendChild(button);

		button.setAttribute("id","messageBtn");
		button.setAttribute("class","userBtn btn btn-custom");
		button.setAttribute("onclick","messageBtnClick();");
		button.setAttribute("style","margin-left: 8px;");
	}

}

function recentActivity(){

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	}

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = "getListings.php";
	var data;
	var params = "purpose=others";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			cards = 0;
			data = JSON.parse(this.responseText);
			for(var u=0;u<data.length;u++){
				createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime,data[u].ImgPath);
			}
			if(!listingRegion.firstChild){
				noRecentActivityDisplay();
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function noRecentActivityDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No active listings added by the user!");
	div.appendChild(divText);
	listingRegion.appendChild(div);
	div.setAttribute("class","no-listings card bg-light");
}

messageBtnAppend();
recentActivity();