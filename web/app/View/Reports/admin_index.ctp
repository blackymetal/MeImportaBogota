<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&language=ja">
</script>

<script type="text/javascript"
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDH_sQwtYfFSRtBaU10Q0aN4jV7Z3GZ7rc&sensor=true">
    </script>
<script type="text/javascript">
  function initialize() {
    var mapOptions = {
      center: new google.maps.LatLng(4.598, -74.076),
      zoom: 10,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);
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