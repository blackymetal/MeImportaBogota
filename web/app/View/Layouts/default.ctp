<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php print $this->Html->charset(); ?>
	<title>
		<?php print $title_for_layout; ?>
	</title>
	<?php
		print $this->Html->meta('icon');

		print $this->Html->css('bootstrap.min.css');
		print $this->Html->css('bootstrap-responsive.min.css');
		print $this->Html->css('chosen.min.css');
		print $this->Html->css('default.css');

		print $this->fetch('meta');
		print $this->fetch('css');
		print $this->Html->script(array('jquery-1.7.2.min.js', 'bootstrap.js', 'markerclusterer.js'), array('inline' => false));

		print $this->fetch('script');
	?>
	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>
<?php
$class = 'logedin';
if(!$this->Session->check('Auth.User.id')) {
	$class = 'logedin';
}
?>
<body class="<?php print $class;?>">
	<div class='container-fluid'><?php
	print $this->Html->image('logo.png');
	?>
	<?php
	if($this->Session->check('Auth.User.id')) {
	?>
	<div class="menu-right pull-right">
		<?php
		printf(__('Bienvenido %s'), $this->Session->read('Auth.User.name'));
		print '&nbsp;'.'&nbsp;'.$this->Html->link(__('Salir'), array('controller' => 'users', 'action' => 'logout', 'admin' => false))	;
		?>
	</div>
	<?php
	}
	?>
	</div>
	<div class="navbar">
    <div class="navbar-inner">
      <div class="container-fluid">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </a>

        <div class="nav-collapse">
					<ul class='nav pull-right nav-menu-right'>
						<li><?php print $this->Html->link(__('Reportes'), array('controller' => 'reports', 'action' => 'index', 'admin' => true))?></li>
					</ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
  </div>

  <div class="container-fluid">
		<div class='row-fluid'>
			<?php
			if ($this->Session->check('Message.flash')) {
				print $this->Session->flash();
			}

			if ($this->Session->check('Message.auth')) {
				print $this->Session->flash('auth', array('element' => 'alert'));
			}
			print $this->fetch('content');
			?>
		</div><!--row-fluid-->
		<hr />
		<div class="footer">
			<p>&copy; Lathink.tv <?php print date('Y');?></p>
		</div>
	</div><!--/.fluid-container-->
	<?php print $this->element('sql_dump'); ?>
</body>
</html>
