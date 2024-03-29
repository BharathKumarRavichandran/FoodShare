var i=0;
var j=0;
var loadUnseenSelfMessages = true;
var username2;
var chatRegion = document.getElementById("chatRegion");
var searchUserValue = document.getElementById("searchUserValue");
var userChatSelect = document.getElementById("userChatSelect");

var newMessageAudio = new Audio("audios/newMessage.mp3");

document.getElementById("searchUserValue").addEventListener("keyup",function(event){

	if(event.keyCode==13){//enter keycode
		searchUserChat();
	}
	else{
		searchUserChatSuggestions();
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
	    			userChatLink(cards,userData[g].Username,userData[g].imagePathOther);
	    			cards++;
	    		}
	    	}

    		if(document.getElementById("userChat"+0)){
    			document.getElementById("userChat"+0).click();
    			document.getElementById("userChat"+0).classList.add("active");
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
	    	if(userData.length==0){
	    		noUserChatsDisplay();
	    	}
	    	else{
	    		var currentUser = userData[0].currentUser;
	    		for(var g=0;g<userData.length;g++){
	    			console.log("hey");
	    			userChatLink(cards,userData[g].Username,userData[g].imagePathOther);
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
	    			userChatLink(cards,userData[g].Username,userData[g].imagePathOther);
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

function userChatLink(cards,username,dpPath){

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
	img.setAttribute("src",dpPath);
	img.setAttribute("onError","this.onerror=null;this.src='display_pictures/default_dp.jpg';");

}

function sendMessage(){

	var message = document.getElementById("chatInput").value;
	var date = new Date();
	var time = formatAMPM(date);
	createSelfMessageBox(message,time,dpPathSelf);
	
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
	var purpose = "retrieveSeenMessages";
	var params = "username2="+username2+"&purpose="+purpose;
	var url = "retrieveMessages.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			chatData = JSON.parse(this.responseText);
			if(chatData.length>0){
				var currentUser = chatData[0].CurrentUser.trim();
				for(var t=0;t<chatData.length;t++){
					if(currentUser==chatData[t].Username1.trim()){
						createSelfMessageBox(chatData[t].Message,chatData[t].MessageTime,chatData[t].imagePathSelf);
					}
					else{
						createOppMessageBox(chatData[t].Message,chatData[t].MessageTime,chatData[t].imagePathOther);
					}
				}
				loadUnseenMessages();
				chatboxScrollCheck();
			}
			else{
				noChatMessagesDisplay();
			}
		}
	};
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader('Content-type','application/x-www-form-urlencoded');
	xmlhttp.send(params);

}

function loadUnseenMessages(){

	if(document.getElementById("noChatMessagesId")){
		while(chatRegion.firstChild){
			chatRegion.removeChild(chatRegion.firstChild);
		}
	}

    var xmlhttp;
	if (window.XMLHttpRequest){
	  		xmlhttp = new XMLHttpRequest();
	} 
	 else{
	  	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	var chatData;
	var purpose = "retrieveUnseenMessages";
	var params = "username2="+username2+"&purpose="+purpose;
	var url = "retrieveMessages.php";
	xmlhttp.onreadystatechange = function(){
		if(this.readyState==4&&this.status==200){
			chatData = JSON.parse(this.responseText);
			if(chatData.length>0){
				var currentUser = chatData[0].CurrentUser.trim();
				for(var t=0;t<chatData.length;t++){
					if(currentUser==chatData[t].Username1.trim()){
						if(loadUnseenSelfMessages==true){
							createSelfMessageBox(chatData[t].Message,chatData[t].MessageTime,chatData[t].imagePathSelf);
						}
					}
					else{
						createOppMessageBox(chatData[t].Message,chatData[t].MessageTime,chatData[t].imagePathOther);
						newMessageAudio.play();
					}
				}
				loadUnseenSelfMessages = false;
				chatboxScrollCheck();
			}
			loadUnseenSelfMessages = false;
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
	div.setAttribute("style","font-size: 19px");	
}

function noChatMessagesDisplay(){
	/*var div = document.createElement("div");
	var divText = document.createTextNode("No chat messages to display!");
	div.appendChild(divText);
	chatRegion.appendChild(div);
	div.setAttribute("id","noChatMessagesId");
	div.setAttribute("class","no-chatmessages");*/
}

userChatInit();

setInterval(loadUnseenMessages,1000);