function createSelfMessageBox(message,time){

	var div = document.createElement("div");
	var img = document.createElement("img");
	var p = document.createElement("p");
	var span = document.createElement("span");

	var pText = document.createTextNode(message);
	var spanText = document.createTextNode(time);

	p.appendChild(pText);
	span.appendChild(spanText);

	div.appendChild(img);
	div.appendChild(p);
	div.appendChild(span);
	document.getElementById("chatRegion").appendChild(div);

	div.setAttribute("class","container container-card darker");
	img.setAttribute("class","right");
	span.setAttribute("class","time-left");

	img.setAttribute("alt","Avatar");
	img.setAttribute("src","assets/avatars/avatar-ninja-1.png");
	img.setAttribute("style","width:100%;");

}

function createOppMessageBox(message,time){

	var div = document.createElement("div");
	var img = document.createElement("img");
	var p = document.createElement("p");
	var span = document.createElement("span");

	var pText = document.createTextNode(message);
	var spanText = document.createTextNode(time);

	p.appendChild(pText);
	span.appendChild(spanText);

	div.appendChild(img);
	div.appendChild(p);
	div.appendChild(span);
	document.getElementById("chatRegion").appendChild(div);

	div.setAttribute("class","container container-card");
	span.setAttribute("class","time-right");

	img.setAttribute("alt","Avatar");
	img.setAttribute("src","assets/avatars/avatar-ninja-2.png");
	img.setAttribute("style","width:100%;");

}