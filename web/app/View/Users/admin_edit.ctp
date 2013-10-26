<?php
echo $this->Html->script('users/admin_edit.js');
?>
<div class="usuarios form">
<?php 
echo sprintf('<h2>%s</h2>', __('Edit User'));
echo $this->Form->create('User', array('class' => 'well'));
?>
	<div class="row-fluid">
  	<div class="span6">
			<fieldset>
				<legend><?php echo __('User Data'); ?></legend>
			<?php
				echo $this->Form->input('id');
				echo $this->Form->input('firstname', array('div' => 'control-group'));
				echo $this->Form->input('lastname', array('div' => 'control-group'));
				echo $this->Form->input('email', array('div' => 'control-group'));
				echo $this->Form->input('client_id', array('div' => 'control-group', 'empty' => true));
				echo $this->Form->input('group_id', array('div' => 'control-group'));
			?>
			</fieldset>
		</div><!--span6-->
		<div class="span6">
			<fieldset>
				<legend>Password</legend>
				<?php
				echo $this->Form->label('changepassword', $this->Form->checkbox('changepassword').__('Change password'), array('class' => 'checkbox', 'after'));
				echo $this->Form->input('password', array('div' => 'control-group'));
				echo $this->Form->input('password2', array('type' => 'password', 'label' => __('Confirmación'), 'div' => 'control-group'));
				echo $this->Form->button(__('Save'), array('type' => 'submit', 'div' => false, 'class' => 'btn btn-primary')).'&nbsp;';
				echo $this->Html->link(__('Cancel'), array('action' => 'index'), array('class' => 'btn'));
				echo $this->Form->end();
				?>
			</fieldset>
		</div><!--span6-->
		</div><!--row-->
</div>