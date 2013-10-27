<?php
App::uses('AppController', 'Controller');
/**
 * Reports Controller
 *
 * @property Report $Report
 * @property PaginatorComponent $Paginator
 */
class ReportsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Report->recursive = 0;
		$this->set('reports', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Report->exists($id)) {
			throw new NotFoundException(__('Invalid report'));
		}
		$options = array('conditions' => array('Report.' . $this->Report->primaryKey => $id));
		$this->set('report', $this->Report->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Report->create();
			if ($this->Report->save($this->request->data)) {
				$this->Session->setFlash(__('The report has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The report could not be saved. Please, try again.'));
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->Report->exists($id)) {
			throw new NotFoundException(__('Invalid report'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Report->save($this->request->data)) {
				$this->Session->setFlash(__('The report has been saved'));
				return $this->redirect(array('action' => 'index'));
			}
			$this->Session->setFlash(__('The report could not be saved. Please, try again.'));
		} else {
			$options = array('conditions' => array('Report.' . $this->Report->primaryKey => $id));
			$this->request->data = $this->Report->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Report->id = $id;
		if (!$this->Report->exists()) {
			throw new NotFoundException(__('Invalid report'));
		}
		$this->request->onlyAllow('post', 'delete');
		if ($this->Report->delete()) {
			$this->Session->setFlash(__('Report deleted'));
			return $this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Report was not deleted'));
		return $this->redirect(array('action' => 'index'));
	}
	
	
	/**
	 * admin_list_json method
	 *
	 * Devuelve la lista de reportes
	 *
	 * @param int $reporttype_id, opcional si llega el parámetro se filtra
	 * @return json
	 */
	public function admin_list_json($reporttype_id = null, $bounds = null) {
		$this->autoRender = false;
		
		App::uses('HtmlHelper', 'View/Helper');
		$Html = new HtmlHelper(new View(null));
		
		header("Pragma: no-cache");
		header("Cache-Control: no-store, no-cache, max-age=0, must-revalidate");
		header('Content-Type: application/json; charset=utf-8');
		
		$json = array(
			'response' => true,
			'data' => '',
			'msg' => ''
		);
		
		if(!is_numeric($reporttype_id)) {
			$reporttype_id = null;
		}
		
		$conditions = array();
		
		if(isset($bounds)) {
			list($latmin, $lngmin, $latmax, $lngmax) = explode(',', $bounds);
			
			$conditions[] = array(
				sprintf('Report.lat >= %s AND Report.lat <= %s', $latmin, $latmax),
				sprintf('Report.lng >= %s AND Report.lng <= %s', $lngmin, $lngmax)
			);
			// (Lat => 1.2393 AND Lat <= 1.5532) AND (Lon >= -1.8184 AND Lon <= 0.4221)
		}
		
		if(isset($reporttype_id)) {
			$conditions[] = array('Report.reporttype_id' => $reporttype_id);
		}
		
		$this->Report->recursive = -1;
		$reports = $this->Report->find('all', array('conditions' => $conditions));
		
		foreach($reports as $i => $report) {
			$image = $Html->url('/img/fotos/'.$report['Report']['image'], true);
			$reports[$i]['Report']['image'] = $image;
		}
		$json['data'] = $reports;
		
		echo json_encode($json);
		exit();
	}
}
