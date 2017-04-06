


var geocoder;
var map;
function initialize() {
  alert("initialzing");
geocoder = new google.maps.Geocoder();
var latlng = new google.maps.LatLng(-34.397, 150.644);
var mapOptions = {
zoom: 8,
center: latlng
}
map = new google.maps.Map(document.getElementById('map'), mapOptions);
codeAddress();
}

function codeAddress() {
var address = document.getElementById("address").innerText;
alert(address);
// alert(address);
geocoder.geocode( { 'address': address}, function(results, status) {
if (status == 'OK') {
  map.setCenter(results[0].geometry.location);
  var marker = new google.maps.Marker({
      map: map,
      position: results[0].geometry.location
  });
  document.getElementById('map').style.visibility = "visible" ;

} else {
  alert('Geocode was not successful for the following reason: ' + status);
}
});
}
