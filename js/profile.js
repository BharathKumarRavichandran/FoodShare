var i=0;
var j=0;
var activityRegion = document.getElementById("activityRegion");
var modal = document.getElementById("modalId");
var selectId = document.getElementById("modalSelectId");

var xmlhttp;
if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
} 
else{
  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
}

function openNewListingModal(){

	modal.style.display = "block";

}

function addListing(){

	var type = selectId.options[selectId.selectedIndex].text;
	var title = document.getElementById("titleInputId").value;
	var desc = document.getElementById("descInputId").value;
	var latitude = markerLat;
	var longitude = markerLng;
	var time = document.getElementById("timeInputId").value;
	var purpose = "addListing";

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params =  "type="+type+"&title="+title+"&desc="+desc+"&latitude="+latitude+"&longitude="+longitude+"&time="+time+"&purpose="+purpose;
	var url = "profile.php";
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

	document.getElementById("titleInputId").value = "";
	document.getElementById("titleInputId").placeholder = "Title";
	document.getElementById("descInputId").value = "";
	document.getElementById("descInputId").placeholder = "Description";
	document.getElementById("timeInputId").value = "";
	document.getElementById("timeInputId").placeholder = "Pick-up Times Eg. Monday evening";
	modal.style.display = "none";

}