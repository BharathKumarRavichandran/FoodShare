var i=0;
var j=0;

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

function sendMessage(){

	var message = document.getElementById("chatInput").value;
	var date = new Date();
	var time = formatAMPM(date);
	createSelfMessageBox(message,time);
	
	chatboxScrollCheck();
	saveMessage(username2,message,time);

	document.getElementById("chatInput").value = "";
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