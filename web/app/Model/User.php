<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {
	
	// Usado con ACL
	public $actsAs = array('Acl' => array('type' => 'requester'));
	
/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre es requerido.'
			)
		),
		'group_id' => array(
			'email' => array(
				'rule' => array('notempty'),
				'message' => 'El grupo es requerido.'
			)
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'El email no es válido.'
			)
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El password es requerido.'
			)
		),
		'password2' => array(
			array('rule' => 'notEmpty', 'message' => 'El password es requerido.', 'on' => 'update'),
			array('rule'=> array('compareData', 'password'), 'message' => 'El password y la confirmación no concuerdan.'),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Group' => array(
			'className' => 'Group',
			'foreignKey' => 'group_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	// ACL Auth
	function parentNode() {
		 if (!$this->id && empty($this->data)) {
				 return null;
		 }
		 $data = $this->data;
		 if (empty($this->data)) {
				 $data = $this->read();
		 }
		 if (!isset($data['User']['group_id'])) {
				 return null;
		 } else {
				 return array('Group' => array('id' => $data['User']['group_id']));
		 }
	}
}
