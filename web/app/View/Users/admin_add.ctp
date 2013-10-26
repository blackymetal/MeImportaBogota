<div class="usuarios form">
<?php 
echo sprintf('<h2>%s</h2>', __('Add User'));
print $this->Form->create('User', array(
	'class' => 'form-inline',
	'inputDefaults' => array(
		'div' => 'control-group',
		'label' => array('class' => 'control-label'),
		'between' => '<div class="controls">',
		'after' => '</div>',
		// 'class' => 'input-small',
		'error' => array('attributes' => array('wrap' => 'div', 'class' => 'alert alert-error'))
	)
));
?>
	<div class="row-fluid">
  	<div class="span6">
			<fieldset>
				<legend><?php echo __('User Data'); ?></legend>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('firstname');
				echo $this->Form->input('lastname');
				echo $this->Form->input('email');
				echo $this->Form->input('client_id', array('empty' => true));
				echo $this->Form->input('group_id', array('empty' => true));
			?>
			</fieldset>
		</div><!--span6-->
		<div class="span6">
			<fieldset>
				<legend>Password</legend>
				<?php
				echo $this->Form->input('password');
				echo $this->Form->input('password2', array('type' => 'password', 'label' => __('Confirm password')));
				echo $this->Form->button(__('Save'), array('type' => 'submit', 'div' => false, 'class' => 'btn btn-primary')).'&nbsp;';
				echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn'));
				echo $this->Form->end();
				?>
			</fieldset>
		</div><!--span6-->
		</div><!--row-->
</div>