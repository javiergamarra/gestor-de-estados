<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Gestor de proyectos</title>
<link rel="shortcut icon" href="/favicon.ico" />
<?php use_javascript('jquery-1.4.2.min.js') ?>
<?php include_javascripts() ?>
<?php include_stylesheets() ?>
<?php use_helper('jQuery');?>
</head>
<body>
<div id="container">
<div id="header">
<div class="content">
<h1><a href="<?php echo url_for('proyecto/index') ?>"> <img
	src="/images/logo.jpg" alt="Proyectos" /> </a></h1>
</div>
<?php if ($sf_user->isAuthenticated()): ?>
<div id="sub_header">

<div class="menu"><a href="<?php echo url_for('proyecto/index') ?>">Proyectos</a></div>
<div class="menu" style="width: 200px"><a
	href="<?php echo url_for('version/index') ?>">Solicitudes de cambio</a></div>
	<?php if($sf_user->hasPermission('administrador')):?>
<div class="menu"><a href="<?php echo url_for('estado/index') ?>">Estados</a></div>
<div class="menu"><a href="<?php echo url_for('tipo/index') ?>">Tipos</a></div>
<div class="menu"><?php echo link_to('Usuarios', 'sf_guard_user') ?></div>
<div class="menu"><?php echo link_to('Grupos', 'sf_guard_group') ?></div>
<div class="menu"><?php echo link_to('Permisos', 'sf_guard_permission') ?></div>
<?php endif;?>
<div class="menu" style="float: right; width: 270px"><?php 
$nombre = $sf_user->getName().' / '.$sf_user->getGrupo();
$numeroMensajes = $sf_user->getAttribute('mensajes');
if ($numeroMensajes or $numeroMensajes >0):
	$nombre = $nombre.' ('.$numeroMensajes.')';
endif;
echo link_to($nombre,'mensaje/index')
?></div>
</div>
<div class="menu" style="float: right; width: 250px"><?php echo link_to('Desloguear ', 'sf_guard_signout') ?></div>
<?php endif ?></div>

<div id="content"><?php if ($sf_user->hasFlash('notice')): ?>
<div class="flash_notice"><?php echo $sf_user->getFlash('notice') ?></div>
<?php endif ?> <?php if ($sf_user->hasFlash('error')): ?>
<div class="flash_error"><?php echo $sf_user->getFlash('error') ?></div>
<?php endif ?>

<div class="content"><?php echo $sf_content ?></div>
</div>

<div id="footer">
<div class="content"><span class="symfony"> powered by <a
	href="http://www.symfony-project.org/"> <img
	src="/~javgama/gestor/web/images/symfony.gif" alt="symfony framework" /> </a> </span>
<ul>
	<li><a href="/~javgama/gestor/web/about.php">Sobre el proyecto</a></li>
</ul>
</div>
</div>
</div>
</body>
</html>
