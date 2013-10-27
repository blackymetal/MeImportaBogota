<?php
class LatlngComponent extends Component{
	// getBoundingBox
	// hacked out by ben brown <ben@xoxco.com>
	// http://xoxco.com/clickable/php-getboundingbox

	// given a latitude and longitude in degrees (40.123123,-72.234234) and a distance in kilometers
	// calculates a bounding box with corners $distance_in_miles away from the point specified.
	// returns $min_lat, $max_lat, $min_lon, $max_lon
	public function getBoundingBox($lat_degrees, $lon_degrees, $distance_in_miles) {
		$radius = 6378.1; // of earth in miles
		// bearings
		$due_north = 0;
		$due_south = 180;
		$due_east = 90;
		$due_west = 270;
		// convert latitude and longitude into radians
		$lat_r = deg2rad($lat_degrees);
		$lon_r = deg2rad($lon_degrees);
		// find the northmost, southmost, eastmost and westmost corners $distance_in_miles away
		// original formula from
		// http://www.movable-type.co.uk/scripts/latlong.html
		$northmost = asin(sin($lat_r) * cos($distance_in_miles/$radius) + cos($lat_r) * sin ($distance_in_miles/$radius) * cos($due_north));
		$southmost = asin(sin($lat_r) * cos($distance_in_miles/$radius) + cos($lat_r) * sin ($distance_in_miles/$radius) * cos($due_south));
		$eastmost = $lon_r + atan2(sin($due_east)*sin($distance_in_miles/$radius)*cos($lat_r),cos($distance_in_miles/$radius)-sin($lat_r)*sin($lat_r));
		$westmost = $lon_r + atan2(sin($due_west)*sin($distance_in_miles/$radius)*cos($lat_r),cos($distance_in_miles/$radius)-sin($lat_r)*sin($lat_r));
		$northmost = rad2deg($northmost);
		$southmost = rad2deg($southmost);
		$eastmost = rad2deg($eastmost);
		$westmost = rad2deg($westmost);
		
		// sort the lat and long so that we can use them for a between query
		if ($northmost > $southmost) {
			$lat1 = $southmost;
			$lat2 = $northmost;
		} else {
			$lat1 = $northmost;
			$lat2 = $southmost;
		}
		
		if ($eastmost > $westmost) {
			$lon1 = $westmost;
			$lon2 = $eastmost;
		} else {
			$lon1 = $eastmost;
			$lon2 = $westmost;
		}
		return array($lat1, $lat2, $lon1, $lon2);
	}
	
	/**
		* Verifica que $lat y $lng se encuentran en $coverage
		* @param string $coverage, puntos de la cobertura
		* @param float $lat, latitud
		* @param float $lng, longitud
		* @return 1 si está en la cobertura de lo contrario devuelve 0
		*/
		public function checkCoverage($coverage, $lat, $lng) {
		$isInZone = 0;

		// Convierte la cobertura en un arreglo de puntos donde cada punto es un arreglo que contiene lat y lng
		$arrayCobertura = explode(';', $coverage);

		$points = array();

		for ($i = 0; $i < count($arrayCobertura); $i++) {
			$arrayLatLng = explode(',', $arrayCobertura[$i]);
			if(count($arrayLatLng) == 2) {
				$points[$i][0] = $arrayLatLng[0];
				$points[$i][1] = $arrayLatLng[1];
			}
		}

		$j = sizeof($points)-1;

		for($i = 0; $i < count($points); $j = $i++) {
			if (((($points[$i][1] <= $lng) && ($lng < $points[$j][1])) || (($points[$j][1] <= $lng) && ($lng < $points[$i][1]))) &&
				($lat < ($points[$j][0] - $points[$i][0]) * ($lng - $points[$i][1]) / ($points[$j][1] - $points[$i][1]) + $points[$i][0]))
				$isInZone++;
		}
		return $isInZone%2;
	}
}
