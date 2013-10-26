<?php
echo $this->Html->script('usuarios/login.js');
echo $this->Html->script('jquery.simplemodal.js');
echo $this->Html->scriptBlock(
	'var url_facebook = "'.$this->Html->url(array('controller' => 'usuarios', 'action' => 'facebook'), true).'";
	var url_check_facebook = "'.$this->Html->url(array('controller' => 'usuarios', 'action' => 'check_facebook'), true).'";
	var url_root = "'.$this->Html->url('/', true).'";'
);
?>
<div class="white-box">
<?php
echo $this->Html->tag('p', __('Si eres usuario registrado ingresa con tu Email y clave'));
echo $this->Form->create();
echo $this->Form->inputs(array(
	'legend' => false,
	'email',
	'password' => array('label' => __('Clave', true),  'value' => '')
));
echo $this->Form->end(__('Ingresar', true));
?>