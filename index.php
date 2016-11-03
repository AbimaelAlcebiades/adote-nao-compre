<?php 

/**
 *@aluno1 - Abimael Alcebíades
 *@aluno2 - Fagner Antunes Dorneles
*/

include_once "system.php"; 

use TrabalhoG2\System;

$system = new System();

$navbarModule = $system->getModule("navbar"); 
$highlighthomeModule = $system->getModule("highlighthome");
$footerModule = $system->getModule("footer");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Adote, não compre!</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="assets\css\bootstrap.css">
	<script src="assets/js/jquery.js"></script>
	<?php echo $system->loadCSS($highlighthomeModule); ?>

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