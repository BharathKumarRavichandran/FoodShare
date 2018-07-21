var map;
var infoWindow;
var markerLat;
var markerLng;
var saveLatitude;
var saveLongitude;
var saveAddress;

var markers = new Array();

function initAutocomplete() {
  var map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 10.7589, lng: 78.8132},//NIT Trichy Co-ordinates
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  google.maps.event.addListener(map, 'click', function(event){
    console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
    markerLat = event.latLng.lat();
    markerLng = event.latLng.lng();

    //Clearing all old markers 
    markers.forEach(function(marker){
      marker.setMap(null);
    });
    markers = [];

    //Adding current new marker
    var myLatlng = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng() );
    markers.push(new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'Your added address!'
    }));

    if(document.getElementById("locationInputId")){
    	saveLocation();//Saving address,lat,lng of current marker location	
    }
    
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function(){//If map viewport changes, bound also changes, so biasing search results
    searchBox.setBounds(map.getBounds());
  });

  // Listen for the event fired when the user selects a prediction and retrieve more details for that place.
  searchBox.addListener('places_changed', function(){//SearchBox places selection event
    var places = searchBox.getPlaces();

    if(places.length == 0){
      return;
    }

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place){
      if (!place.geometry){
        console.log("Returned place contains no geometry");
        return;
      }

      var icon = { //Creating icon for each places returned
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),//setting the origin prop of icon
        anchor: new google.maps.Point(17, 34),//setting where to display icon-image wrt to marker's bottom anchor point
        scaledSize: new google.maps.Size(25, 25)
      };

      // Creating a marker for each place returned in the searchBox.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location //gives (lat,lng) object
      }));

      if(place.geometry.viewport){
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport); //union takes "other" object(LatLngBounds|LatLngBoundsLiteral) as its parameter
      }
      else{
        bounds.extend(place.geometry.location); //extend takes "point" object as its parameter
      }

    });
    map.fitBounds(bounds);//Adjusting the map and changing to entered address to fit the bound changes
  });
}

function saveLocation(){

	if(document.getElementById("locationInputId")){
		saveAddress = document.getElementById("locationInputId").value;
	}

	console.log(saveAddress);
  
  if(saveAddress!=""){
    address_to_coordinates(saveAddress);
    document.getElementById("pac-input").value = saveAddress;
  }
  else{
    saveLatitude = markerLat;
    saveLongitude = markerLng;
    saveAddress = coordinates_to_address(markerLat,markerLng);
  }

  console.log("Latitude: "+saveLatitude+" "+", longitude: "+saveLongitude+" Address : "+saveAddress); 

}

function address_to_coordinates(address){

  var geocoder = new google.maps.Geocoder();

  geocoder.geocode({'address': address},function(results, status){

  if (status == google.maps.GeocoderStatus.OK) {
      saveLatitude = results[0].geometry.location.lat();
      saveLongitude = results[0].geometry.location.lng();
      console.log(saveLatitude+" "+saveLongitude);
      } 
  });

}

function coordinates_to_address(lat,lng){

    var latlng = new google.maps.LatLng(lat,lng);
    var geocoder = new google.maps.Geocoder();

    geocoder.geocode({'latLng': latlng}, function(results,status){

        if(status == google.maps.GeocoderStatus.OK) {
            if(results[0]){
                var address = (results[0].formatted_address);
                saveAddress = address;
                console.log(saveAddress);
                if(document.getElementById("locationInputId")){
                	document.getElementById("locationInputId").placeholder = saveAddress;
                }
                return address;
            }
            else{
            	saveAddress = "Address error, delete and re-add listing";
                console.log('No results found');
                return saveAddress;
            }
        }
        else{
            var error = {
                'ZERO_RESULTS': 'National Institute of Technology, Tiruchirappalli'
            }
            saveAddress = "Address error, delete and re-add listing";
            console.log(error[status]);
            return saveAddress;
        }
    });
}