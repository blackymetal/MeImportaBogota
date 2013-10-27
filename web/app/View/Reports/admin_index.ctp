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

function setMarkers(map, locations) {
	var markers = [];
	for (var i = 0; i < locations.length; i++) {
		
		var spot = locations[i];
		
		var myLatLng = new google.maps.LatLng(spot['Report']['lat'], spot['Report']['lng']);
    var marker = new google.maps.Marker({
			position: myLatLng,
			title: spot['Report']['name'],
			zIndex: i
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
      <h3>Dirección</h3>
      <h3>Fotografía</h3>
    </div>
    <div class="span10">
      <div id="map-canvas"/>
    </div>
  </div>
</div>