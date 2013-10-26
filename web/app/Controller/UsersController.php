<?php
class UsersController extends AppController {
	public $components = array('Acl');
/**
 * beforeFilter method
 *
 * Set the black hole to prevent white-screen-of-death symptoms for invalid form submissions.
 *
 * @access public
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->set('authFields', $this->Auth->fields);
		$this->Auth->allow(
			'login',
			'logout',
			// 'admin_acl'
		);

		$this->Auth->autoRedirect = false;
		if (isset($this->Security)) {
			$this->Security->blackHoleCallback = '_blackHole';
		}
	}

	public function admin_delete($id = null) {
		$this->User->id = $id;
		if ($id && $this->User->exists()) {
			if ($this->User->delete($id)) {
				$this->Session->setFlash(__('User was deleted', true), 'default', array('class' => 'msgsuccess'));
			} else {
				$this->Session->setFlash(__('Problem deleting User', true), 'default', array('class' => 'msgwarning'));
			}
		} else {
			$this->Session->setFlash(sprintf(__('User with id %1$s doesn\'t exist', true), $id), 'default', array('class' => 'msgerror'));
		}
		$this->redirect(array('action' => 'index'));
	}

	/**
	 * admin_index method
	 * 
	 * Lista los usuarios 
	 *
	 */
		public function admin_index() {
			$conditions = array();
			// pr($this->request);
			if($this->request->is('get')) {
				if(isset($this->request->query['texto'])) {
					$conditions[] = array('OR' => array(
						'User.email' => $this->request->query['texto'],
						'User.name LIKE ?' => "%".$this->request->query['texto']."%"
					));
				}
			}

			$this->Paginator->settings = array(
				'conditions' => $conditions,
				'paramType' => 'querystring',
				'limit' => 20
			);

			$this->set('usuarios', $this->paginate());
		}
	/**
	 * super_add method
	 * 
	 * Adiciona un usuario
	 *
	 */
		public function admin_add() {
			if ($this->request->is('post')) {
				$this->User->create();
				// Si viene el password lo encripta
				if(isset($this->request->data['User']['password']) && !empty($this->request->data['User']['password'])) {
					// Encripta el password
					$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
				}
				// Si viene el password lo encripta
				if(isset($this->request->data['User']['password2']) && !empty($this->request->data['User']['password2'])) {
					$this->request->data['User']['password2'] = AuthComponent::password($this->request->data['User']['password2']);
				}
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('El usuario ha sido guardado.'), 'default', array('class' => 'alert alert-success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash('<a class="close" data-dismiss="alert">×</a>'.__('El usuario no pudo ser guardado. Por favor, intente nuevamente.'), 'default', array('class' => 'alert alert-error'));
					$this->request->data['User']['password'] = null;
					$this->request->data['User']['password2'] = null;
				}
			}
			$groups = $this->User->Group->find('list');
			$clients = $this->User->Client->find('list');
			$this->set(compact('groups', 'clients'));
		}

	/**
	 * super_edit method
	 * 
	 * Edita un usuario
	 * 
	 * @access public
	 * @param int $id id del usuario a editar
	 * @return void
	 */
		public function admin_edit($id = null) {
			$this->User->id = $id;
			if (!$this->User->exists()) {
				$this->Session->setFlash(__('El usuario no existe.'), 'default', array('class' => 'alert alert-error'));
				return $this->redirect(array('action' => 'index'));
			}
			if ($this->request->is('post') || $this->request->is('put')) {
				// Si viene el password lo encripta
				if(isset($this->request->data['User']['password']) && !empty($this->request->data['User']['password'])) {
					// Encripta el password
					$this->request->data['User']['password'] = AuthComponent::password($this->request->data['User']['password']);
				}
				// Si viene el password lo encripta
				if(isset($this->request->data['User']['password2']) && !empty($this->request->data['User']['password2'])) {
					$this->request->data['User']['password2'] = AuthComponent::password($this->request->data['User']['password2']);
				}
				if ($this->User->save($this->request->data)) {
					$this->Session->setFlash(__('El usuario ha sido guardado.'), 'default', array('class' => 'alert alert-success'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('El usuario no pudo ser guardado. Por favor, intente nuevamente.'), 'default', array('class' => 'alert alert-error'));
				}
			} else {
				$this->request->data = $this->User->read(null, $id);
			}
			$this->request->data['User']['password'] = null;
			$this->request->data['User']['password2'] = null;
			$groups = $this->User->Group->find('list');
			$clients = $this->User->Client->find('list');
			$this->set(compact('groups'));
		}

	function login() {
		//Auth Automagic
		if ($this->Auth->login()) {
			$this->Cookie->write('logged.Auth', $this->Session->read('Auth'), true, '365 Days');
			return $this->redirect(array('controller' => 'reports', 'action' => 'index', 'admin' => true));
		}
		$this->set('title_for_layout', 'Login');
	}

/**
 * logout method
 *
 * Delete the users cookie (if any), log them out, and send them a parting flash meassage. If no user is logged in just
 * send them back to where they came from (no reference to the session refer).
 *
 * @access public
 * @return void
 */
	function logout() {
		if ($this->Auth->user()) {
			$this->Session->destroy();
			$this->Cookie->delete('logged');
			$this->Session->setFlash(__('now logged out', true));
		}
		$this->redirect($this->Auth->logout());
	}
	
	/**
	 * Generate a random string
	 * 
	 * @param $length, password length
	 * @param $possible, chars
	 * @return string
	 */
	function generateRandomString ($length = 8, $possible = '0123456789abcdefghijklmnopqrstuvwxyz') {
		// initialize variables
		$password = "";
		$i = 0;

		// add random characters to $password until $length is reached
		while ($i < $length) {
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) { 
				$password .= $char;
				$i++;
			}
		}
		return $password;
	}

/**
 * blackHole method. Handles form submissions deemed invalid by the security component
 *
 * If a login is blackholed, there are 2 possible causes
 * 	1) The user went to /users/login but the form was tampered or the security token out of date
 * 	2) They used the sidebar login form, and the <not-users> controller doesn't use the security component
 *
 * In the first case, there is nothing to do but send the user back to the login form. In the second case, check if
 * their form submission contains a valid (session) user login token, and if so allow them to login; Otheriwse send to
 * the login form. This logic allows the users controller to use the security component, without forcing the rest of the
 * application to do so.
 *
 * If a user is already logged in, and the current action is not a login, then the user submitted a stale form -
 * call the parent blackHole handling method.
 *
 * @param mixed $reason
 * @return void
 * @access protected
 */
	function _blackHole($reason = null) {
		if ($reason == 'auth' && $this->action == 'login') {
			$formToken = isset($this->request->data['User']['login_token'])?$this->request->data['User']['login_token']:false;
			$sessionToken = $this->Session->read('User.login_token');
			if (!isset($this->request->data['_Token']) && $formToken && $sessionToken && $formToken === $sessionToken) {
				return true;
			}
			$token = Security::hash(String::uuid(), null, true);
			$this->Session->write('User.login_token', $token);
			$this->Session->setFlash(__('Invalid login submission', true));
			$this->redirect($this->Auth->loginAction);
		}
		return parent::_blackHole($reason);
	}
	
	public function admin_acl() {
		$this->autoRender = false;
		$aco = new Aco();
		$mi_aco = array(
			'alias' => 'admin_delete',
			'parent_id' => 64,
			'model' => null,
			'foreign_key' => null
		);
		$aco->create($mi_aco);
		$aco->save($mi_aco);
	}
	
}