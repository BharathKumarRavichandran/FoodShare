var i=0;
var j=0;
var cards = 0;
var listingRegion = document.getElementById("listingRegion");
var modal = document.getElementById("modalId");
var selectId = document.getElementById("modalSelectId");

var xmlhttp;
if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
} 
else{
  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

function init(){
	document.getElementById("myListingsId").click();
}

function openNewListingModal(){

	document.getElementById("expiryDateId").value = new Date().toDateInputValue();
	modal.style.display = "block";

}

function addListing(){

	var type = selectId.options[selectId.selectedIndex].text;
	var title = document.getElementById("titleInputId").value;
	var desc = document.getElementById("descInputId").value;
	var time = document.getElementById("timeInputId").value;
	var expiryDate = document.getElementById("expiryDateId").value;
	var purpose = "addListing";

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var params =  "type="+type+"&title="+title+"&desc="+desc+"&address="+saveAddress+"&latitude="+saveLatitude+"&longitude="+saveLongitude+"&time="+time+"&expiryDate="+expiryDate+"&purpose="+purpose;
	var url = "saveListing.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

	document.getElementById("titleInputId").value = "";
	document.getElementById("titleInputId").placeholder = "Title";
	document.getElementById("descInputId").value = "";
	document.getElementById("descInputId").placeholder = "Description";
	document.getElementById("timeInputId").value = "";
	document.getElementById("timeInputId").placeholder = "Pick-up Times Eg. Monday evening";
	document.getElementById("expiryDateId").value = new Date().toDateInputValue();
	modal.style.display = "none";

}

function myListings(){

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	}

	var children = document.getElementById("sidenav").children;
	for(t=0;t<children.length;t++){
		if(children[t].classList.contains("active")){
			children[t].classList.remove("active");
		}
	} 
	document.getElementById("myListingsId").classList.add("active");

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = "getListings.php";
	var data;
	var params = "purpose=self";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			cards = 0;
			data = JSON.parse(this.responseText);
			for(var u=0;u<data.length;u++){
				createCard(cards,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
			}
			if(!listingRegion.firstChild){
				noListingDisplay();
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function noListingDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No Listings added by you!");
	div.appendChild(divText);
	listingRegion.appendChild(div);
	div.setAttribute("class","no-listings card bg-light");
}

function followDataDisplay(y){

	var children = document.getElementById("sidenav").children;
	for(t=0;t<children.length;t++){
		if(children[t].classList.contains("active")){
			children[t].classList.remove("active");
		}
	} 

	y.classList.add("active");

	var clickText = y.innerHTML.trim();

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	} 

	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var url = "followData.php";
	var params = "";
	var userData;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	cards=0;
	    	userData = JSON.parse(this.responseText);
	    	if(userData.length==0){
	    		noUsersDisplay();
	    	}
	    	else{
	    		var currentUser = userData[0].currentUser;
	    		for(var g=0;g<userData.length;g++){
	    			if(clickText=="Following"){
	    				var array = userData[g].Following.split(",");
	    				for(var d=0;d<array.length-1;d++){
	    					createUserBox(cards,array[d],"Following");
	    					cards++;
	    				}		
	    			}
	    			else if(clickText=="Followers"){
	    				var array = userData[g].Followers.split(",");
	    				for(var d=0;d<array.length-1;d++){
	    					var btnText = "Follow";
	    					var followingArray = userData[g].Following.split(",");
	    					for(var x=0;x<followingArray.length;x++){
	    						if(array[d]==followingArray[x]){
		    						btnText = "Following";
		    					}
	    					}
	    					createUserBox(cards,array[d],btnText);
	    					cards++;
	    				}		
	    			}
	    		}
	    	}
	   	}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

init();