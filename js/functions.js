/*----------------------------------Function written to remove element easily using .remove()-------------------------------------------*/
Element.prototype.remove = function() {
    this.parentElement.removeChild(this);
}
NodeList.prototype.remove = HTMLCollection.prototype.remove = function() {
    for(var i = this.length - 1; i >= 0; i--) {
        if(this[i] && this[i].parentElement) {
            this[i].parentElement.removeChild(this[i]);
        }
    }
}

/*------------------------------------- Function that returns time in AM/PM by feeding date object -----------------------------------*/
function formatAMPM(date) {
  var hours = date.getHours();
  var minutes = date.getMinutes();
  var ampm = hours >= 12 ? 'PM' : 'AM';
  hours = hours % 12;
  hours = hours ? hours : 12; // the hour '0' should be '12'
  minutes = minutes < 10 ? '0'+minutes : minutes;
  var strTime = hours + ':' + minutes + ' ' + ampm;
  return strTime;
}

/*--------------------------Function to convert normal date string to date input value which can be set in input[type=date]----------------*/ 
Date.prototype.toDateInputValue = (function() { 
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
});

/*--------------------------Function to get the current style value by feeding element-id(el) and property(styleProp)-----------------------*/
function getStyle(el,styleProp){
    var x = document.getElementById(el);
    if (x.currentStyle)
        var y = x.currentStyle[styleProp];
    else if (window.getComputedStyle)
        var y = document.defaultView.getComputedStyle(x,null).getPropertyValue(styleProp);
    return y;
}

/*---------------------------------------Function to stop audio the current audio from playing----------------------------------*/
function stopAudio(audio){
    audio.pause();
    audio.currentTime = 0;
}

function home(){
	window.location = "home.php";
}

function profile(){
	window.location = "profile.php";
}

function messages(){
    window.location = "messages.php";
}

function messageBtnClick(){
  window.location = "messages.php"; 
}

function settings(){
  window.location = "settings.php";
}

function logout(){
	window.location = "logout.php";
}