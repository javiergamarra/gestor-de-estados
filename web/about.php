<!-- apps/frontend/templates/layout.php -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
 "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Gestor de proyectos</title>

<?php include ("/home/grini/javgama/miweb/gestor/lib/helper/class.subversion.php");

?>



<link rel="shortcut icon" href="/favicon.ico" />
<link rel="stylesheet" type="text/css" media="screen"
	href="/~javgama/gestor/web/css/main.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="/~javgama/gestor/web/css/listados.css" />
<link rel="stylesheet" type="text/css" media="screen"
	href="/~javgama/gestor/web/css/formulario.css" />
</head>
<body>
<div id="container">
<div id="header">
<div class="content">
<h1><img src="/images/logo.jpg" alt="Proyectos" /></h1>
</div>

<div class="content">
<h1>Práctica de PGP realizada por:</h1>
<ul>
<li>
Javier Gamarra</li>
<li>Carmen Loriente</li>
<li>Albano Narganes</li>
<li>Francisco Javier Garcia</li>
</ul>
<h1><?php
$svn = new subversion();
$svn->addFile('proyect', '/home/grini/javgama/miweb/gestor/web/uploads/');
?></h1>
</div>
</div>

<div id="footer">
<div class="content"><span class="symfony"> powered by <a
	href="http://www.symfony-project.org/"> <img
	src="/~javgama/gestor/web/images/symfony.gif" alt="symfony framework" />
</a> </span>
<ul>
	<li><a href="/~javgama/gestor/web/about.php">Sobre el proyecto</a></li>
</ul>
</div>
</div>
</div>

</body>
</html>
