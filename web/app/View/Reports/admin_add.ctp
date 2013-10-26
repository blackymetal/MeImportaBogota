<div class="reports form">
<?php echo $this->Form->create('Report'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Report'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('gps');
		echo $this->Form->input('image');
		echo $this->Form->input('institution_id');
		echo $this->Form->input('reconfirmed');
		echo $this->Form->input('email');
		echo $this->Form->input('location_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Reports'), array('action' => 'index')); ?></li>
	</ul>
</div>
