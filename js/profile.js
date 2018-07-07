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

function imgUpload(){

	var data = "";

	$.ajax({
		url:'imgUpload.php',
		data:data,
		processData:false,
		contentType:false,
		type:'POST',
		success:function(msg){
			console.log(msg);
		}
	});

}


function addListing(){

	var type = selectId.options[selectId.selectedIndex].text;
	var title = document.getElementById("titleInputId").value;
	var desc = document.getElementById("descInputId").value;
	var time = document.getElementById("timeInputId").value;
	var expiryDate = document.getElementById("expiryDateId").value;
	var purpose = "addListing";

	var params =  "type="+type+"&title="+title+"&desc="+desc+"&address="+saveAddress+"&latitude="+saveLatitude+"&longitude="+saveLongitude+"&time="+time+"&expiryDate="+expiryDate+"&purpose="+purpose;

	var file = document.getElementById("fileToUpload").files[0];
	var formData = new FormData();
	formData.append('fileToUpload',file);
	formData.append('type',type);
	formData.append('title',title);
	formData.append('desc',desc);
	formData.append('address',saveAddress);
	formData.append('latitude',saveLatitude);
	formData.append('longitude',saveLongitude);
	formData.append('time',time);
	formData.append('expiryDate',expiryDate);
	formData.append('purpose',purpose);

	$.ajax({
		url:'saveListing.php',
		data:formData,
		processData:false,
		contentType:false,
		type:'POST',
		success:function(msg){
			console.log(msg);
			if(document.getElementById("myListingsId").classList.contains("active")){
				document.getElementById("myListingsId").click();
			}
		}
	});

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
				createCard(cards,data[u].Listed,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime,data[u].ImgPath);
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

function unlistedListings(){

	while(listingRegion.firstChild){
		listingRegion.removeChild(listingRegion.firstChild);
	}

	var children = document.getElementById("sidenav").children;
	for(t=0;t<children.length;t++){
		if(children[t].classList.contains("active")){
			children[t].classList.remove("active");
		}
	} 
	document.getElementById("unlistedListingsId").classList.add("active");

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
				if(data[u].Listed=="no"){
					createCard(cards,data[u].Listed,data[u].listingId,data[u].Username,data[u].Type,data[u].Title,data[u].Description,data[u].Address,data[u].PickupTime,data[u].ExpiryDate,data[u].CreationTime,data[u].ImgPath);
				}
			}
			if(!listingRegion.firstChild){
				noUnlistedListingDisplay();
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

function noUnlistedListingDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No Unlisted Listings to display!");
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

function createCard(cards,listed,id,username,type,title,desc,location,pickupTime,expiryDate,creationTime,imgPath){

	var li = document.createElement("li");
	var titleDiv = document.createElement("div");
	var imgDiv = document.createElement("div");
	var img = document.createElement("img");
	var descDiv = document.createElement("div");
	var locationDiv = document.createElement("div");
	var locateIcon = document.createElement("i");
	var defLocSpan = document.createElement("span");
	var ptDiv = document.createElement("div");
	var timeIcon = document.createElement("i");
	var defTimeSpan = document.createElement("span"); 
	var ctDiv = document.createElement("div");
	var calIcon = document.createElement("i");
	var defCTSpan = document.createElement("span");
	var chipDiv = document.createElement("div");
	var chipImg = document.createElement("img");
	var chipSpan = document.createElement("span");
	var idDiv = document.createElement("div");
	var btnsDiv = document.createElement("div");
	var editBtn = document.createElement("button");
	var unlistBtn = document.createElement("button");
	var delBtn = document.createElement("button");
	var locSpan2 = document.createElement("span");
	var timeSpan2 = document.createElement("span");

	var titleText = document.createTextNode(title);
	var descText = document.createTextNode(desc);
	var defLocSpanText = document.createTextNode("Approximate Location : ");
	var locationText = document.createTextNode(location);
	var defTimeSpanText = document.createTextNode("Pickup Times : ");
	var ptText = document.createTextNode(pickupTime);
	var defCTSpanText = document.createTextNode("Listed on : ");
	var ctText = document.createTextNode(creationTime);
	var	chipSpanText = document.createTextNode(username);
	var editText = document.createTextNode("EDIT");
	var unlistText;
	if(listed=="yes"){
		unlistText = document.createTextNode("UNLIST");
	}
	else{
		unlistText = document.createTextNode("LIST");
	}
	var delText = document.createTextNode("DELETE");
	var idText = document.createTextNode(id);

	titleDiv.appendChild(titleText);
	descDiv.appendChild(descText);
	locationDiv.appendChild(locateIcon);
	defLocSpan.appendChild(defLocSpanText);
	locationDiv.appendChild(defLocSpan);
	locSpan2.appendChild(locationText);
	locationDiv.appendChild(locSpan2);
	ptDiv.appendChild(timeIcon);
	defTimeSpan.appendChild(defTimeSpanText);
	ptDiv.appendChild(defTimeSpan);
	timeSpan2.appendChild(ptText);
	ptDiv.appendChild(timeSpan2);
	ctDiv.appendChild(calIcon);
	defCTSpan.appendChild(defCTSpanText);
	ctDiv.appendChild(calIcon);
	ctDiv.appendChild(defCTSpan);
	ctDiv.appendChild(ctText);
	chipDiv.appendChild(chipImg);
	chipSpan.appendChild(chipSpanText);
	chipDiv.appendChild(chipSpan);

	editBtn.appendChild(editText);
	unlistBtn.appendChild(unlistText);
	delBtn.appendChild(delText);

	li.appendChild(titleDiv);
	if(!(imgPath === null && typeof imgPath === "object")){
		if(!(imgPath==='NULL'||imgPath==""||!imgPath||imgPath==='null')){
			imgDiv.appendChild(img);
			li.appendChild(imgDiv);
		}	
	}
	li.appendChild(descDiv);
	li.appendChild(locationDiv);
	li.appendChild(ptDiv);
	li.appendChild(ctDiv);
	li.appendChild(chipDiv);
	idDiv.appendChild(idText);
	li.appendChild(idDiv);
	btnsDiv.appendChild(editBtn);
	btnsDiv.appendChild(unlistBtn);
	btnsDiv.appendChild(delBtn);
	li.appendChild(btnsDiv);
	document.getElementById("listingRegion").appendChild(li);

	if(!(imgPath === null && typeof imgPath === "object")){
		if(!(imgPath==='NULL'||imgPath==""||!imgPath||imgPath==='null')){
			img.setAttribute("src",imgPath);
			img.setAttribute("id","img"+cards);
			imgDiv.setAttribute("class","imgDivClass");
			img.setAttribute("class","imgClass");	
			img.setAttribute("alt","food-picture");
			img.setAttribute("onerror","this.style.display='none';");
		}	
	}

	li.setAttribute("id","li"+cards);
	idDiv.setAttribute("id","idDiv"+cards);
	titleDiv.setAttribute("id","title"+cards);
	descDiv.setAttribute("id","desc"+cards);
	locSpan2.setAttribute("id","location"+cards);
	timeSpan2.setAttribute("id","pickupTime"+cards);
	chipDiv.setAttribute("id","chipDiv"+cards);
	chipSpan.setAttribute("id","username"+cards);
	editBtn.setAttribute("id","editBtn"+cards);

	unlistBtn.setAttribute("id","unlistBtn"+cards);
	delBtn.setAttribute("id","delBtn"+cards);

	li.setAttribute("class","container container-card card bg-light listingCardLi");
	titleDiv.setAttribute("class","cardTitle");
	descDiv.setAttribute("class","cardDesc");
	locationDiv.setAttribute("class","card-div");
	ptDiv.setAttribute("class","card-div");
	ctDiv.setAttribute("class","card-div");
	chipDiv.setAttribute("class","chip");

	defLocSpan.setAttribute("class","defSpan");
	defTimeSpan.setAttribute("class","defSpan");
	defCTSpan.setAttribute("class","defSpan");

	btnsDiv.setAttribute("class","btnsDiv");
	editBtn.setAttribute("class","btn btn-custom card-btn");
	unlistBtn.setAttribute("class","btn btn-custom card-btn");
	delBtn.setAttribute("class","btn btn-custom card-btn");
	
	locateIcon.setAttribute("class","fa fa-map-marker listing-card-icons");
	timeIcon.setAttribute("class","fa fa-clock-o listing-card-icons");
	calIcon.setAttribute("class","fa fa-calendar listing-card-icons");

	chipImg.setAttribute("src","assets/avatars/avatar-ninja-2.png");
	chipImg.setAttribute("alt","Person");
	chipImg.setAttribute("width","96");
	chipImg.setAttribute("height","96");

	chipDiv.setAttribute("onclick","viewProfileChipClick(this)");
	editBtn.setAttribute("onclick","editListing(this);");
	unlistBtn.setAttribute("onclick","editlistListing(this);");
	delBtn.setAttribute("onclick","delListing(this);");

	idDiv.setAttribute("style","display: none;");

}

function editListing(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("editBtn");
    var k = parseInt(res[1]);

    if(y.innerHTML=="EDIT"){
    	document.getElementById("title"+k).setAttribute("contentEditable",true);
		document.getElementById("desc"+k).setAttribute("contentEditable",true);
		document.getElementById("pickupTime"+k).setAttribute("contentEditable",true);

		document.getElementById("title"+k).classList.add("content-editable");
		document.getElementById("desc"+k).classList.add("content-editable");
		document.getElementById("pickupTime"+k).classList.add("content-editable");

		y.innerHTML = "SAVE";
    }

    else if(y.innerHTML=="SAVE"){
    	document.getElementById("title"+k).setAttribute("contentEditable",false);
		document.getElementById("desc"+k).setAttribute("contentEditable",false);
		document.getElementById("pickupTime"+k).setAttribute("contentEditable",false);

		document.getElementById("title"+k).classList.remove("content-editable");
		document.getElementById("desc"+k).classList.remove("content-editable");
		document.getElementById("pickupTime"+k).classList.remove("content-editable");

		y.innerHTML = "EDIT";
    }

    var title = document.getElementById("title"+k).innerHTML;
    var desc = document.getElementById("desc"+k).innerHTML;
    var pickupTime = document.getElementById("pickupTime"+k).innerHTML;
    var id = document.getElementById("idDiv"+k).innerHTML;

	editListingDb(id,title,desc,pickupTime);    

}

function editListingDb(id,title,desc,pickupTime){

	var purpose = "editListing";

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var params = "id="+id+"&title="+title+"&desc="+desc+"&pickupTime="+pickupTime+"&purpose="+purpose;
	var url = "saveListing.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function editlistListing(y){ //For unlisting and listing cards

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("unlistBtn");
    var k = parseInt(res[1]);

    var id = document.getElementById("idDiv"+k).innerHTML;
    var purpose = "editlistListing";
    var listed;

    if(y.innerHTML.trim() == "UNLIST"){
    	listed = "no";
    	y.innerHTML = "LIST";
    }
    else if(y.innerHTML.trim() =="LIST"){
    	listed = "yes";	
    	y.innerHTML = "UNLIST";
    }

    if(document.getElementById("unlistedListingsId").classList.contains("active")){

	    document.getElementById("li"+k).remove();

	    if(!listingRegion.firstChild){
	    	noUnlistedListingDisplay();
	    }	

    }

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params = "id="+id+"&listed="+listed+"&purpose="+purpose;
	var url = "saveListing.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function delListing(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("delBtn");
    var k = parseInt(res[1]);

    var id = document.getElementById("idDiv"+k).innerHTML;
    var purpose = "deleteListing";

   	document.getElementById("li"+k).remove();

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var params = "id="+id+"&purpose="+purpose;
	var url = "saveListing.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

init();