<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH_sQwtYfFSRtBaU10Q0aN4jV7Z3GZ7rc&sensor=true">
    </script>
<script type="text/javascript">
  
  function initialize() {
  var mapOptions = {
    zoom: 10,
    center: new google.maps.LatLng(-33.9, 151.2),
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById('map-canvas'),
                                mapOptions);

  setMarkers(map, cities);
}

/**
 * Data for the markers consisting of a name, a LatLng and a zIndex for
 * the order in which these markers should display on top of each
 * other.
 */

var json = {"response":true,"data":[
			{"Report":{"id":"1","name":"hueco","gps":"4.767406,-74.046949","image":null,"lat":"-33.890542","lng":"151.274856","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}},
			{"Report":{"id":"1","name":"hueco2","gps":"4.767406,-74.046949","image":null,"lat":"-33.923036","lng":"151.259052","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}},
			{"Report":{"id":"1","name":"hueco3","gps":"4.767406,-74.046949","image":null,"lat":"-34.028249","lng":"151.157507","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}},
			{"Report":{"id":"1","name":"hueco4","gps":"4.767406,-74.046949","image":null,"lat":"-33.950198","lng":"151.259302","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}},
			{"Report":{"id":"2","name":"hueco5","gps":"-33.950198,151.259302","image":null,"lat":"-33.80010128657071","lng":"151.28747820854187","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}}],"msg":""};


var cities = [];

for (var i = 0; i < json['data'].length; i++) {
	    
	    cities.push([json['data'][i]['Report']['name'], json['data'][i]['Report']['lat'], json['data'][i]['Report']['lng'], i]);
	}


function setMarkers(map, locations) {
  // Add markers to the map

  // Marker sizes are expressed as a Size of X,Y
  // where the origin of the image (0,0) is located
  // in the top left of the image.

  // Origins, anchor positions and coordinates of the marker
  // increase in the X direction to the right and in
  // the Y direction down.
  
  // Shapes define the clickable region of the icon.
  // The type defines an HTML &lt;area&gt; element 'poly' which
  // traces out a polygon as a series of X,Y points. The final
  // coordinate closes the poly by connecting to the first
  // coordinate.
  var shape = {
      coord: [1, 1, 1, 20, 18, 20, 18 , 1],
      type: 'poly'
  };
  for (var i = 0; i < locations.length; i++) {
    var beach = locations[i];
    var myLatLng = new google.maps.LatLng(beach[1], beach[2]);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        shape: shape,
        title: beach[0],
        zIndex: beach[3]
    });
  }
}

google.maps.event.addDomListener(window, 'load', initialize);


	/*var json = {"response":true,"data":[{"Report":{"id":"1","name":"hueco","gps":"4.767406,-74.046949","image":null,"lat":"4.767406000000","lng":"-74.046949000000","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}},{"Report":{"id":"2","name":"hueco2","gps":"4.767406000001,-74.046949000001","image":null,"lat":"4.767406000001","lng":"-74.046949000001","reporttype_id":"1","reconfirmed":"1","email":null,"location_id":"1","created":null}}],"msg":""};

	for (var i = 0; i < json['data'].length; i++) {
	    
	    var myLatlng = new google.maps.LatLng(json['data'][i]['Report']['lat'], json['data'][i]['Report']['lng']);
		
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: 'Hello!'
		});	

	    console.log(json['data'][i]['Report']['lat'],
	    json['data'][i]['Report']['lng']);
	}

  



  google.maps.event.addDomListener(window, 'load', initialize);*/
</script>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <h1>Área</h1>
      <h1>Punto de interés</h1>
      <h3>Dirección</h3>
      <h3>Fotografía</h3>
    </div>
    <div class="span10">
      <div id="map-canvas"/>
    </div>
  </div>
</div>