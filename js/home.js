var i=0;
var j=0;
var cards = 0;
var type = "Offering";
var disConstraint = "<10KM";
var listingRegion = document.getElementById("listingRegion");
var modal = document.getElementById("modalId");
var selectId1 = document.getElementById("modalSelectId1");
var selectId2 = document.getElementById("modalSelectId2");
var searchValue = document.getElementById("searchValue");

var xmlhttp;
if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
} 
else{
  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

document.getElementById("searchValue").addEventListener("keyup",function(event){
	if(event.keyCode==13){ //enter key
		searchUser();
	}
},false);

function deg2rad(x) {
   return x*Math.PI/180;
}

/*-----------------------Calculating distance between two latitude, longitude using Haversine Formula------------------------*/
function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2){
	var R = 6371; // Radius of the earth in km
	var dLat = deg2rad(lat2-lat1);
	var dLon = deg2rad(lon2-lon1);
	var a = Math.sin(dLat/2)*Math.sin(dLat/2)+Math.cos(deg2rad(lat1))*Math.cos(deg2rad(lat2))*Math.sin(dLon/2)*Math.sin(dLon/2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	var d = R * c; // Distance in km
	return d;
}

function initialise(){

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
	var params = "purpose=all";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			cards = 0;
			data = JSON.parse(this.responseText);
			for(var u=0;u<data.length;u++){
				createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
			}
			if(!listingRegion.firstChild||data.length==0){
				noListingDisplay();
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);
}

function searchUser(){

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
	var userSearchValue = searchValue.value;
	var url = "getUserSearchData.php";
	var params = "userSearchValue="+userSearchValue;
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

	    			var btnText = "Follow";
	    			var isfollowing = false;
	    			if(userData[g].Username==currentUser){
		    			btnText = "View Profile";
		    		}
	    			if(userData[g].Followers!="NULL"||!userData[g].Followers){
	    				var followingArray = userData[g].Followers.split(",");
		    			for(var x=0;x<followingArray.length-1;x++){
		    				if(currentUser==followingArray[x]){
		    					isfollowing = true;
		    					btnText = "Following";
		    				}
		    			}
	    			}
	    			createUserBox(cards,userData[g].Username,btnText);
	    			cards++;
	    		}
	    	}
	   	}
	    searchValue.value = "";
	    searchValue.placeholder = "Search User";
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function browseListings(){

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	}

	type = selectId1.options[selectId1.selectedIndex].text;
	disConstraint = selectId2.options[selectId2.selectedIndex].text;

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = "getListings.php";
	var data;
	var params = "purpose=all";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			cards = 0;
			data = JSON.parse(this.responseText);
			for(var u=0;u<data.length;u++){
				var distance  = getDistanceFromLatLonInKm(markerLat,markerLng,data[u].Latitude,data[u].Longitude);
				if(disConstraint=="<10KM"&&distance<10){
					createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="10KM - 30KM"&&(distance>=10&&distance<30)){
					createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="30KM - 90KM"&&(distance>=30&&distance<90)){
					createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="All Listings"){
					createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
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

function openRefineListingModal(){

	modal.style.display = "block";

}

function refineListings(){

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	}

	type = selectId1.options[selectId1.selectedIndex].text;
	disConstraint = selectId2.options[selectId2.selectedIndex].text;

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var url = "getListings.php";
	var data;
	var params = "purpose=all";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			cards = 0;
			data = JSON.parse(this.responseText);
			for(var u=0;u<data.length;u++){
				
				var distance  = getDistanceFromLatLonInKm(markerLat,markerLng,data[u].Latitude,data[u].Longitude);

				if(type.trim() == data[u].Type.trim()){

					if(disConstraint=="<10KM"&&distance<10){
						createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
					}
					else if(disConstraint=="10KM - 30KM"&&(distance>=10&&distance<30)){
						createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
					}
					else if(disConstraint=="30KM - 90KM"&&(distance>=30&&distance<90)){
						createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
					}
					else if(disConstraint=="All Listings"){
						createCard(cards,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
					}

				}
			
			}
			if(!listingRegion.firstChild){
				noListingDisplay();
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

	document.getElementById("pac-input").value = "";
	document.getElementById("pac-input").placeholder = "Locate by place";
	modal.style.display = "none";

}

function noListingDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No Listings near you!");
	div.appendChild(divText);
	listingRegion.appendChild(div);
	div.setAttribute("class","no-listings card bg-light");
}

function noUsersDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No Users to display!");
	div.appendChild(divText);
	listingRegion.appendChild(div);
	div.setAttribute("class","no-listings card bg-light");
}

initialise();