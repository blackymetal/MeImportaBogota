<?php
class ApiController extends AppController {
	public $uses = array('Institution', 'Reporttype', 'Report', 'Location');
	
	public $helper = array('Html');
	
	public function beforeFilter() {
		parent::beforeFilter();
		// Autoriza el acceso al método registro sin necesidad de estar registrado
		$this->Auth->allow(
			'execute'
		);
	}
	
	/**
		* REST Ejecuta las acciones 
		* @param string $accion, nombre de la accion a ejecutar
		* @return json
		*/
	public function execute($action) {
		$this->autoRender = false;
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		header('Content-Type: application/json; charset=utf-8');
		
		// Valida la firma
		if(!$this->check($action)) {
			$json = array(
				'response' => false,
				'msg' => __('La firma no es válida')
			);
			
			echo json_encode($json);
			exit();
		}
		
		// Captura la accion
		switch($action) {
			case 'nearby':
				$this->nearby();
				break;
			default:
			$json = array(
				'response' => false,
				'msg' => sprintf(__('La acción "%s" no existe'), $action)
			);
			echo json_encode($json);
			exit();
		}
	}
	
	/**
		* Devuelve todos los reportes que se encuentren cerca del punto gps
		* @param string $this->request->query['reporttype_id'] tipo de reporte
		* @param string $this->request->query['lat'] latitude
		* @param string $this->request->query['lng'] longitude
		* @return print json
		*/
	private function nearby() {
		
		$json = array(
			'response' => true,
			'data' => '',
			'msg' => ''
		);
		
		$this->Report->unbindModel(array('belongsTo' => array('Reporttype')));
		// SELECT * FROM reports WHERE acos(sin(4.767406) * sin(lat) + cos(4.767406) * cos(lat) * cos(lng - (-74.046949))) * 6371 <= 0.015;
		$reports = $this->Report->find('all', array(
			'conditions' => array(
				'Report.reporttype_id' => $this->request->query['reporttype_id'],
				sprintf('acos(sin(%1$s) * sin(Report.lat) + cos(%1$s) * cos(Report.lat) * cos(Report.lng - (%2$s))) * 6371 <=', $this->request->query['lat'], $this->request->query['lng']) => 0.015 
			)
		));
		
		$json['data'] = $reports;
		
		echo json_encode($json);
		exit();
	}
	
	/**
		* Verifica la firma
		* @param string $action, los demás parámetros llegan post/get timestamp y sign
		* @return json
		*/
	private function check($action) {
		$this->autoRender = false;
		
		$private_key = 'meimportabogota20131026';
		
		// Si es POST o PUT
		if($this->request->is('post') || $this->request->is('put')) {
			$timestamp = $this->request->data['timestamp'];
			
			$sign = $this->request->data['sign'];
		} else if($this->request->is('get')) { // Si es GET
			$timestamp = $this->request->query['timestamp'];
			$sign = $this->request->query['sign'];
		}
		
		// Valida el timestamp
		if((time() - $timestamp) > 120) {
			return false;
		}
		
		$_sign = md5(sprintf('%s~%s~%s', $private_key, $action, $timestamp));
		
		return ($sign == $_sign);
	}
	
	/**
		* Verifica que $lat y $lng se encuentran en $coverage
		* @param string $coverage, puntos de la cobertura
		* @param float $lat, latitud
		* @param float $lng, longitud
		* @return 1 si está en la cobertura de lo contrario devuelve 0
		*/
	private function checkCoverage($coverage, $lat, $lng) {
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