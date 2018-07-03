function createCard(cards,type,title,desc,location,pickupTime,expiryDate,creationTime){

	var li = document.createElement("li");
	var titleDiv = document.createElement("div");
	var descDiv = document.createElement("div");
	var locationDiv = document.createElement("div");
	var ptDiv = document.createElement("div");
	var ctDiv = document.createElement("div");

	var titleText = document.createTextNode(title);
	var descText = document.createTextNode(desc);
	var locationText = document.createTextNode("Approximate Location : "+location);
	var ptText = document.createTextNode("Pickup Times : "+pickupTime);
	var ctText = document.createTextNode("Creation Time : "+creationTime);

	titleDiv.appendChild(titleText);
	descDiv.appendChild(descText);
	locationDiv.appendChild(locationText);
	ptDiv.appendChild(ptText);
	ctDiv.appendChild(ctText);

	li.appendChild(titleDiv);
	li.appendChild(descDiv);
	li.appendChild(locationDiv);
	li.appendChild(ptDiv);
	li.appendChild(ctDiv);
	document.getElementById("listingRegion").appendChild(li);

	li.setAttribute("class","container card bg-light");

}