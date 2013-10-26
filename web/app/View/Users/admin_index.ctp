<div class="usuarios index">
	<h2><?php echo __('Users');?></h2>
	
	<div class="well">
		<?php
		echo $this->Form->create(null, array('type' => 'GET'));
		echo $this->Form->input('texto', array('label' => __('Email/Name'), 'div' => 'control-group'));
		echo $this->Form->button('Search', array('class' => 'btn'));
		echo $this->Form->end();
		?>
	</div>
	
	<div class="actions">
		<h3><?php echo __('Actions'); ?></h3>
		<?php echo $this->Html->link('<i class="icon-plus-sign"></i>'.__('New User'), array('action' => 'add'), array('class' => 'btn', 'escape' => false)); ?>
	</div>
	<br/>
	<table class='table table-striped table-bordered'>
		<thead>
			<tr>
					<th class="actions"><?php echo __('Actions');?></th>
					<th><?php echo $this->Paginator->sort('firstname');?></th>
					<th><?php echo $this->Paginator->sort('lastname');?></th>
					<th><?php echo $this->Paginator->sort('email');?></th>
					<th><?php echo $this->Paginator->sort('phone');?></th>
					<th><?php echo $this->Paginator->sort('group_id');?></th>
					<th><?php echo $this->Paginator->sort('created', __('Created'));?></th>
			</tr>
		</thead>
		<tbody>
	<?php
	foreach ($usuarios as $usuario): ?>
	<tr>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $usuario['User']['id'])); ?>
			<?php 
			// echo $this->Form->postLink(__('Borrar'), array('action' => 'delete', $usuario['User']['id']), null, __('¿Está seguro de querer borrar el usuario "%s"?', $usuario['User']['nombre']));
			?>
		</td>
		<td><?php echo h($usuario['User']['firstname']); ?>&nbsp;</td>
		<td><?php echo h($usuario['User']['lastname']); ?>&nbsp;</td>
		<td><?php echo h($usuario['User']['email']); ?>&nbsp;</td>
		<td><?php echo h($usuario['User']['phone']); ?>&nbsp;</td>
		<td><?php echo h($usuario['Group']['name']); ?>&nbsp;</td>
		<td><?php echo h($usuario['User']['created']); ?>&nbsp;</td>
	</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
	<?php
	$this->Paginator->options(array('url' => $this->request->query, 'convertKeys' => array('texto')));
	print $this->element('pagination');
	?>
</div>