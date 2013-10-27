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
	var elem = document.createElement("img");

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
  
  elem.src = photo;
  javascript:document.getElementById('spot_photo').appendChild(elem);

  javascript:document.getElementById('spot_latitude').innerHTML= latitude;
  javascript:document.getElementById('spot_longitude').innerHTML= longitude;
}


function setMarkers(map, locations) {
	var markers = [];
	for (var i = 0; i < locations.length; i++) {
		
		var spot = locations[i];
		
    var latitude = spot['Report']['lat'];
    var longitude = spot['Report']['lng'];
    var name = spot['Report']['name'];
    var image = spot['Report']['image'];

		var myLatLng = new google.maps.LatLng(latitude, longitude);
    
    var marker = new google.maps.Marker({
			position: myLatLng,
			title: name,
      photo: image,
			zIndex: i
		});

    markers.push(marker);

    changeSpot(marker, i);
   
	}

  function changeSpot(marker, num) {
    google.maps.event.addListener(marker, 'click', function() {
      //infowindow.open(marker.get('map'), marker);
      setSpotInfo(marker.title,marker.photo,marker.position.lb,marker.position.mb);
      console.log(marker.position.mb);
    });
  }
	
  

  var markerCluster = new MarkerClusterer(map, markers);

  

}

google.maps.event.addDomListener(window, 'load', initialize);

</script>

<div class="container-fluid">
  <div class="row-fluid">
    <div class="span2">
      <!--<h1>Área</h1>-->
      <h1>Punto de interés</h1>
      <h3>Descripción</h3>
      <span id = "spot_info">
        Selecciona un punto de tu interés    
      </span>  
      <h3>Fotografía</h3>
      <div id = "spot_photo">
      </div>  
      <h3>Latitud</h3>
      <span id = "spot_latitude">
        Selecciona un punto de tu interés
      </span>  
      <h3>Longitud</h3>
      <span id = "spot_longitude">
        Selecciona un punto de tu interés
      </span>  
    </div>
    <div class="span10">
      <div id="map-canvas"/>
    </div>
  </div>
</div>

