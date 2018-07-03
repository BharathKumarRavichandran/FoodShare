var i=0;
var j=0;
var cards = 0;
var type = "Offering";
var disConstraint = "<10KM";
var listingRegion = document.getElementById("listingRegion");
var modal = document.getElementById("modalId");
var selectId1 = document.getElementById("modalSelectId1");
var selectId2 = document.getElementById("modalSelectId2");

var xmlhttp;
if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
} 
else{
  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

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
				createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
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
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="10KM - 30KM"&&(distance>=10&&distance<30)){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="30KM - 90KM"&&(distance>=30&&distance<90)){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="All Listings"){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
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
				if(disConstraint=="<10KM"&&distance<10){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="10KM - 30KM"&&(distance>=10&&distance<30)){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="30KM - 90KM"&&(distance>=30&&distance<90)){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
				}
				else if(disConstraint=="All Listings"){
					createCard(cards,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime);
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