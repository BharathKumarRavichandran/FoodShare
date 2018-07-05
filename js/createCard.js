function createCard(cards,id,username,type,title,desc,location,pickupTime,expiryDate,creationTime){

	var li = document.createElement("li");
	var titleDiv = document.createElement("div");
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

	var titleText = document.createTextNode(title);
	var descText = document.createTextNode(desc);
	var defLocSpanText = document.createTextNode("Approximate Location : ");
	var locationText = document.createTextNode(location);
	var defTimeSpanText = document.createTextNode("Pickup Times : ");
	var ptText = document.createTextNode(pickupTime);
	var defCTSpanText = document.createTextNode("Listed on : ");
	var ctText = document.createTextNode(creationTime);
	var	chipSpanText = document.createTextNode(username);
	var idText = document.createTextNode(id);

	titleDiv.appendChild(titleText);
	descDiv.appendChild(descText);
	locationDiv.appendChild(locateIcon);
	defLocSpan.appendChild(defLocSpanText);
	locationDiv.appendChild(defLocSpan);
	locationDiv.appendChild(locationText);
	ptDiv.appendChild(timeIcon);
	defTimeSpan.appendChild(defTimeSpanText);
	ptDiv.appendChild(defTimeSpan);
	ptDiv.appendChild(ptText);
	ctDiv.appendChild(calIcon);
	defCTSpan.appendChild(defCTSpanText);
	ctDiv.appendChild(calIcon);
	ctDiv.appendChild(defCTSpan);
	ctDiv.appendChild(ctText);
	chipDiv.appendChild(chipImg);
	chipSpan.appendChild(chipSpanText);
	chipDiv.appendChild(chipSpan);
	li.appendChild(titleDiv);
	li.appendChild(descDiv);
	li.appendChild(locationDiv);
	li.appendChild(ptDiv);
	li.appendChild(ctDiv);
	li.appendChild(chipDiv);
	idDiv.appendChild(idText);
	li.appendChild(idDiv);
	document.getElementById("listingRegion").appendChild(li);

	idDiv.setAttribute("id","idDiv"+cards);
	chipDiv.setAttribute("id","chipDiv"+cards);
	chipSpan.setAttribute("id","username"+cards);

	li.setAttribute("class","container card bg-light listingCardLi");
	titleDiv.setAttribute("class","cardTitle");
	descDiv.setAttribute("class","cardDesc");
	locationDiv.setAttribute("class","card-div");
	ptDiv.setAttribute("class","card-div");
	ctDiv.setAttribute("class","card-div");
	chipDiv.setAttribute("class","chip");

	defLocSpan.setAttribute("class","defSpan");
	defTimeSpan.setAttribute("class","defSpan");
	defCTSpan.setAttribute("class","defSpan");
	
	locateIcon.setAttribute("class","fa fa-map-marker listing-card-icons");
	timeIcon.setAttribute("class","fa fa-clock-o listing-card-icons");
	calIcon.setAttribute("class","fa fa-calendar listing-card-icons");

	chipDiv.setAttribute("onclick","viewProfileChipClick(this)");
	chipImg.setAttribute("src","assets/avatars/avatar-ninja-2.png");
	chipImg.setAttribute("alt","Person");
	chipImg.setAttribute("width","96");
	chipImg.setAttribute("height","96");

	idDiv.setAttribute("style","display: none;");

}