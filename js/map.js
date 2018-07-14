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
    center: {lat: -33.8688, lng: 151.2195},
    zoom: 13,
    mapTypeId: 'roadmap'
  });

  google.maps.event.addListener(map, 'click', function( event ){
    console.log( "Latitude: "+event.latLng.lat()+" "+", longitude: "+event.latLng.lng() ); 
    markerLat = event.latLng.lat();
    markerLng = event.latLng.lng();

    markers.forEach(function(marker){
      marker.setMap(null);
    });
    markers = [];

    var myLatlng = new google.maps.LatLng(event.latLng.lat(),event.latLng.lng() );
    markers.push(new google.maps.Marker({
        position: myLatlng,
        map: map,
        title: 'Hello World!'
    }));
  });

  // Create the search box and link it to the UI element.
  var input = document.getElementById('pac-input');
  var searchBox = new google.maps.places.SearchBox(input);
  map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

  // Bias the SearchBox results towards current map's viewport.
  map.addListener('bounds_changed', function() {
    searchBox.setBounds(map.getBounds());
  });

  var markers = [];
  // Listen for the event fired when the user selects a prediction and retrieve
  // more details for that place.
  searchBox.addListener('places_changed', function() {
    var places = searchBox.getPlaces();

    if (places.length == 0) {
      return;
    }

    // For each place, get the icon, name and location.
    var bounds = new google.maps.LatLngBounds();
    places.forEach(function(place) {
      if (!place.geometry) {
        console.log("Returned place contains no geometry");
        return;
      }
      var icon = {
        url: place.icon,
        size: new google.maps.Size(71, 71),
        origin: new google.maps.Point(0, 0),
        anchor: new google.maps.Point(17, 34),
        scaledSize: new google.maps.Size(25, 25)
      };

      // Create a marker for each place.
      markers.push(new google.maps.Marker({
        map: map,
        icon: icon,
        title: place.name,
        position: place.geometry.location
      }));

      if (place.geometry.viewport) {
        // Only geocodes have viewport.
        bounds.union(place.geometry.viewport);
      } else {
        bounds.extend(place.geometry.location);
      }
    });
    map.fitBounds(bounds);
  });
}

function saveLocation(){

  saveAddress = document.getElementById("locationInputId").value;
  
  if(saveAddress!=""){
    address_to_coordinates(saveAddress);
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

  geocoder.geocode( { 'address': address}, function(results, status) {

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

    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if(status == google.maps.GeocoderStatus.OK) {
            if(results[0]){
                var address = (results[0].formatted_address);
                saveAddress = address;
                console.log(saveAddress);
                return address;
            }
            else{
                alert('No results found');
            }
        }
        else{
            var error = {
                'ZERO_RESULTS': 'National Institute of Technology, Tiruchirappalli'
            }

            // alert('Geocoder failed due to: '+status);
            console.log(error[status]);
        }
    });
}
