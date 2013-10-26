<?php
App::uses('AppModel', 'Model');
class Group extends AppModel {
/**
* Display field
*
* @var string
*/
	
	public $actsAs = array('Acl' => array('requester'));
	
 	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'El nombre es requerido.'
			)
		)
	);
	
	function parentNode() {
		return null;
	}
}