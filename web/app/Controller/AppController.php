<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	// Adiciona los helpers a usar en toda la aplicación
	// Form funciones para los formularios y sus elementos, input, formfield, legend, labels etc.
	// Html funciones para tags, imagenes, css, 
	// Js funciones para controllar javascript, como imprimir bloques de código javascript
	// Time funciones para formatear fecha hora
	// Session funciones de sesión
	// Number ayuda a formatear los números en formato moneda etc.
	// Funciones wrapper de Vendor/manejarDatos.php
	public $helpers = array('Form', 'Html', 'Js', 'Time', 'Session', 'Number');

	// Componentes a usar en toda la aplicación, 
	// RequestHandler es necesario para detectar llamados AJAX desde el navegador
	// Session maneja los valores de sesión además de los mensajes con setFlash
	// Latlng conversión de direcciones
	// Facebook verifica si el usuario se encuentra registrado con Facebook
	// Auth controla el acceso
	public $components = array('RequestHandler', 'Session', 'Paginator','Cookie',
		'Auth' => array(
			'loginAction' => array(
				'controller' => 'users',
				'action' => 'login',
				'admin' => false
			),
			'authError' => 'La sesión no es válida o no se encuentra registrado.',
			'authenticate' => array(
				'Form' => array(
				'userModel' => 'User',
				'fields' => array('username' => 'email')
				)
			)
		)
	);
	
	public function beforeFilter() {
		parent::beforeFilter();
		
		// Autoriza el acceso a métodos sin necesidad de estar registrado
		$this->Auth->allow('display');
		
		// Auto log in
		if(!$this->Session->check('Auth.User.id')) {
			if('' != $this->Cookie->read('logged.Auth.User.id')) {
				$this->Session->destroy();
				$login['User']['email'] = $this->Cookie->read('logged.Auth.User.email');
				$login['User']['password'] = $this->Cookie->read('logged.Auth.User.password');
				$this->Session->write('Auth.User', $this->Cookie->read('logged.Auth.User'));
			}
		}
		
		// Pass settings in using 'all'
		$this->Auth->authorize = array(
			'Actions' => array('actionPath' => 'controllers', 'userModel' => 'User')
		);
	}
	
	public function beforeRender() {
		if (isset($this->params['prefix']) && !isset($this->params['plugin']) || (isset($this->params['isAjax']) && $this->params['isAjax'] != 1 && !isset($this->params['plugin']))) {
			//Prevent override if set within controller
			if($this->layout == 'default' && isset($this->params['prefix'])) {
				// Asigna un layout basado en el prefix (admin, super)
				// $this->layout = $this->params['prefix']; // Quitar el comentario si se va a usar
			}
		} else if(isset($this->params['plugin'])) {
			$this->view = 'View';
		}
		if (!isset ($this->viewVars['data'])) {
			$this->set('data', $this->data);
		}
		if (!isset ($this->viewVars['modelClass'])) {
			$this->set('modelClass', $this->modelClass);
		}
	}
}
