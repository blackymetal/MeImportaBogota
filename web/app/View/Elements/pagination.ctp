<?php
echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records of {:count}')
));
?>
<div class="pagination">
<?php
	echo "<ul>";
	echo $this->Paginator->prev(
		'« ' . __('previous'), 
		array('class' => '', 'tag' => 'li'), 
		'<a href="#nogo">« ' . __('previous')."</a>", 
		array('class' => 'prev disabled', 'tag' => 'li', 'escape' => false)
	);
	$numbers = $this->Paginator->numbers(array('separator' => '', 'class' => '', 'tag' => 'li', 'currentClass' => 'active'));
	echo preg_replace('#<li class="active">([0-9]+)</li>#', '<li class="active"><a href="#nogo">$1</a></li>', $numbers);
	echo $this->Paginator->next(
		__('next') . ' »', 
		array('class' => '', 'tag' => 'li'), 
		'<a href="#nogo">'.__('next') . ' »</a>', 
		array('class' => 'next disabled', 'tag' => 'li', 'escape' => false)
	);
	echo "</ul>";
?>
</div>
