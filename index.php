<?php 

/**
 *@aluno1 - Abimael Alcebíades Farias Silva
 *@aluno2 - Fagner Antunes Dorneles
*/

// Inclue arquivo principal do sistema.
include_once "system.php"; 

// Declaração do uso de classes.
use TrabalhoG2\System;

// Inicia o sistema.
$system = New System();

// Carrega módulos.
$navbarModule 			= $system->getModule("navbar"); 
$login 					= $system->getModule("login");
$highlighthomeModule 	= $system->getModule("highlighthome");
$footerModule 			= $system->getModule("footer");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Adote, não compre!</title>
	<meta charset="utf-8">
	<?php /* Carrega arquivos CSS. */ ?>
	<script src="assets/js/jquery.js"></script>
	<?php echo  $system->loadJavascript("login", "login"); ?>
	
	<?php /* Carrega arquivos Javascript. */ ?>
	<link rel="stylesheet" type="text/css" href="assets\css\bootstrap.css">
	<?php echo  $system->loadCSS($highlighthomeModule); ?>

</head>
<body>
	<?php
		// Tenta realizar a inserção dos módulos.
		try {
			$navbarModule->toRender("navbar", "default");			
			$highlighthomeModule->toRender("highlighthome", "default");			
			$footerModule->toRender("footer", "default");
		// Captura exeções.
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	?>
</body>
</html>