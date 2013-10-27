<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH_sQwtYfFSRtBaU10Q0aN4jV7Z3GZ7rc&sensor=false">
</script>

<?php
	print $this->Html->scriptBlock(
	 'var url_reports = "'.$this->Html->url(array('controller' =>'reports', 'action' => 'list_json', 'admin' => true), true).'";
	 '
	);
?>

<script type="text/javascript">
	
	var map;
	
	function initialize() {
		var mapOptions = {
			zoom: 10,
			center: new google.maps.LatLng(4.509345, -74.058838),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		}
  
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
		
		$.ajax({
			url: url_reports + '/null/'
		}).done(function(json) {
			if(json.response) {
				setMarkers(map,json.data);
			}
		});
		
		// google.maps.event.addListener(map, "bounds_changed", function() {
		// // send the new bounds back to your server
		// 	$.ajax({
		// 		url: url_reports + '/null/' /+ map.getBounds().toUrlValue()
		// 	}).done(function(json) {
		// 		if(json.response) {
		// 			setMarkers(map,json.data);
		// 		}
		// 	});
		// });
	}

function setSpotInfo(spot, photo, latitude, longitude){
  javascript:document.getElementById('spot_info').innerHTML= spot;
  javascript:document.getElementById('spot_photo').innerHTML= photo;
  javascript:document.getElementById('spot_latitude').innerHTML= latitude;
  javascript:document.getElementById('spot_longitude').innerHTML= longitude;
}


function setMarkers(map, locations) {
	var markers = [];
	for (var i = 0; i < locations.length; i++) {
		
		var spot = locations[i];
		
		var myLatLng = new google.maps.LatLng(spot['Report']['lat'], spot['Report']['lng']);
    
    var marker = new google.maps.Marker({
			position: myLatLng,
			title: spot['Report']['name'],
      photo: spot['Report']['lat'],
			zIndex: i
		});
		
    google.maps.event.addListener(marker, 'click', function() {
      setSpotInfo(marker.title,spot['Report']['image'],spot['Report']['lat'],spot['Report']['lng']);
      console.log(spot);
    });

    markers.push(marker);
	}
	var markerCluster = new MarkerClusterer(map, markers);
}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <h1>Área</h1>
      <h1>Punto de interés</h1>
      <h3>Descripción</h3>
      <span id = "spot_info">
        Place here the spot info    
      </span>  
      <h3>Fotografía</h3>
      <span id = "spot_photo">
        Place here the spot photo    
      </span>  
      <h3>Latitude</h3>
      <span id = "spot_latitude">
        Selecciona un punto de tu interés
      </span>  
      <h3>Longitude</h3>
      <span id = "spot_longitude">
        Selecciona un punto de tu interés
      </span>  
    </div>
    <div class="span10">
      <div id="map-canvas"/>
    </div>
  </div>
</div>

