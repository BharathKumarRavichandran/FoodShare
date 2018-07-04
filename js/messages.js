var i=0;
var j=0;
var username2;
var chatRegion = document.getElementById("chatRegion");
var searchUserValue = document.getElementById("searchUserValue");
var userChatSelect = document.getElementById("userChatSelect");

document.getElementById("searchUserValue").addEventListener("keyup",function(event){

	if(event.keyCode==13){//enter keycode
		searchUserChat();
	}

},false);

document.getElementById("chatInput").addEventListener("keyup",function(event){

	if(event.keyCode==13){//enter keycode
		sendMessage();
	}

},false);

/*------- For Chat box scroll to stay at bottom of the div ----------*/
function chatboxScrollCheck(){
	var out = document.getElementById("chatRegion");
	var scrollToBottom = out.scrollTop + 1 <= out.scrollHeight - out.clientHeight;
	if(scrollToBottom){
    	out.scrollTop = out.scrollHeight - out.clientHeight;
	}
}

function userChatInit(){

	while(userChatSelect.firstChild){
		userChatSelect.removeChild(userChatSelect.firstChild);
	}

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var userSearchValue = "";
	var url = "getConnectors.php";
	var params = "userSearchValue="+userSearchValue;
	var userData;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	cards=0;
	    	userData = JSON.parse(this.responseText);
	    	if(userData.length==0){
	    		noUserChatsDisplay();
	    	}
	    	else{
	    		var currentUser = userData[0].currentUser;
	    		for(var g=0;g<userData.length;g++){
	    			userChatLink(cards,userData[g].Username);
	    			cards++;
	    		}
	    	}

    		if(document.getElementById("userChat"+0)){
    			document.getElementById("userChat"+0).click();
    			document.getElementById("userChat"+0).classList.add("active");
    			console.log(document.getElementById("userChat"+0).classList.contains("active"));
    			username2 = userData[0].Username;
    		}
    		else{
    			noChatMessagesDisplay();
    		}
    		chatboxScrollCheck();
	   	}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function searchUserChatSuggestions(){

	while(userChatSelect.firstChild){
		userChatSelect.removeChild(userChatSelect.firstChild);
	}

	var userSearchValue = searchUserValue.value;

	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var userSearchValue = searchUserValue.value;
	var url = "getConnectors.php";
	var params = "userSearchValue="+userSearchValue;
	var userData;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	cards=0;
	    	userData = JSON.parse(this.responseText);
	    	console.log(userData);
	    	if(userData.length==0){
	    		noUserChatsDisplay();
	    	}
	    	else{
	    		var currentUser = userData[0].currentUser;
	    		for(var g=0;g<userData.length;g++){
	    			userChatLink(cards,userData[g].Username);
	    			cards++;
	    		}
	    	}
	   	}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function searchUserChat(){

	while(userChatSelect.firstChild){
		userChatSelect.removeChild(userChatSelect.firstChild);
	}

	var xmlhttp;
	if (window.XMLHttpRequest) {
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var userSearchValue = searchUserValue.value;
	var url = "getConnectors.php";
	var params = "userSearchValue="+userSearchValue;
	var userData;
	xmlhttp.onreadystatechange = function(){
	    if(this.readyState==4&&this.status==200){
	    	cards=0;
	    	userData = JSON.parse(this.responseText);
	    	if(userData.length==0){
	    		noUserChatsDisplay();
	    	}
	    	else{
	    		var currentUser = userData[0].currentUser;
	    		for(var g=0;g<userData.length;g++){
	    			userChatLink(cards,userData[g].Username);
	    			cards++;
	    		}
	    	}
	   	}
	    searchUserValue.value = "";
	    searchUserValue.placeholder = "Search User";
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function userChatLink(cards,username){

	var div = document.createElement("div");
	var img = document.createElement("img");
	var p = document.createElement("p");

	var pText = document.createTextNode(username);

	p.appendChild(pText);

	div.appendChild(img);
	div.appendChild(p);
	document.getElementById("userChatSelect").appendChild(div);

	div.setAttribute("id","userChat"+cards);
	p.setAttribute("id","username"+cards);

	div.setAttribute("class","container-chatlink sidenavlinks userchatlinks");
	img.setAttribute("class","img-avatar");

	div.setAttribute("onclick","userChatLinkClick(this);");
	img.setAttribute("alt","Avatar");
	img.setAttribute("src","assets/avatars/avatar-ninja-2.png");

}

function sendMessage(){

	var message = document.getElementById("chatInput").value;
	var date = new Date();
	var time = formatAMPM(date);
	createSelfMessageBox(message,time);
	
	chatboxScrollCheck();
	saveMessage(username2,message,time);

	document.getElementById("chatInput").value = "";
	document.getElementById("chatInput").placeholder = "Type a Message";

}

function saveMessage(username2,message,msgTimeStamp){

	var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	var purpose = "saveMessage";
	var params = "username2="+username2+"&message="+message+"&msgTimeStamp="+msgTimeStamp+"&purpose="+purpose;
	var url = "saveMessage.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			console.log(this.responseText);
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function userChatLinkClick(y){

	var idAttr = y.getAttribute("id");
    var res = idAttr.split("userChat");
    var k = parseInt(res[1]);
    username2 = document.getElementById("username"+k).innerHTML;

    while(chatRegion.firstChild){
		chatRegion.removeChild(chatRegion.firstChild);
	}

    var children = document.getElementById("userChatSelect").children;
	for(t=0;t<children.length;t++){
		if(children[t].classList.contains("active")){
			children[t].classList.remove("active");
		}
	} 
	y.classList.add("active");

    var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var chatData;
	var purpose = "retrieveMessages";
	var params = "username2="+username2+"&purpose="+purpose;
	var url = "retrieveMessages.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			chatData = JSON.parse(this.responseText);
			var currentUser = chatData[0].CurrentUser.trim();
			for(var t=0;t<chatData.length;t++){
				if(currentUser==chatData[t].Username1.trim()){
					createSelfMessageBox(chatData[t].Message,chatData[t].MessageTime);
				}
				else{
					createOppMessageBox(chatData[t].Message,chatData[t].MessageTime);
				}
			}
			if(chatData.length<1){
				noChatMessagesDisplay();
			}
			chatboxScrollCheck();
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function noUserChatsDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No User chats to display!");
	div.appendChild(divText);
	userChatSelect.appendChild(div);
	div.setAttribute("class","no-userchats");	
}

function noChatMessagesDisplay(){
	var div = document.createElement("div");
	var divText = document.createTextNode("No chat messages to display!");
	div.appendChild(divText);
	chatRegion.appendChild(div);
	div.setAttribute("class","no-chatmessages");	
}
userChatInit();