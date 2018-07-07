function createUserBox(cards,username,btnText){

	var li = document.createElement("span");
	var userSpan = document.createElement("span");
	var btnSpan = document.createElement("span");
	var button = document.createElement("button");
	var button2;
	if(btnText!="View Profile"){
		button2 = document.createElement("button");
	}

	var userSpanText = document.createTextNode(username);
	var buttonText = document.createTextNode(btnText);
	var button2Text;
	if(btnText!="View Profile"){
		button2Text = document.createTextNode("View Profile");
		button2.appendChild(button2Text);
	}

	userSpan.appendChild(userSpanText);
	button.appendChild(buttonText);

	li.appendChild(userSpan);
	btnSpan.appendChild(button);
	if(btnText!="View Profile"){
		btnSpan.appendChild(button2);
	}	
	li.appendChild(btnSpan);
	listingRegion.appendChild(li);

	userSpan.setAttribute("id","username"+cards);
	button.setAttribute("id","followBtn"+cards);
	if(btnText!="View Profile"){
		button2.setAttribute("id","viewProfileBtn"+cards);
	}

	li.setAttribute("class","userBoxClass liClass container container-card card card-body bg-light");
	li.setAttribute("style","display:inline-block");
	userSpan.setAttribute("class","userNameDisp");
	button.setAttribute("class","userBtn btn btn-custom");
	button.setAttribute("onclick","followBtnClick(this)");
	if(btnText!="View Profile"){
		button2.setAttribute("class","userBtn btn btn-custom");
		button2.setAttribute("onclick","viewProfileBtnClick(this)");
	}

}