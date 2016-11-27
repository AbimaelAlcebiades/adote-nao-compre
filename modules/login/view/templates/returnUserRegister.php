<?php 

// Inclue arquivo principal do sistema.
include_once "system.php"; 

// Declaração do uso de classes.
use TrabalhoG2\System;

// Inicia o sistema.
$system = New System();

// Carrega módulos.
$navbarModule 			= $system->getModule("navbar"); 
$footerModule 			= $system->getModule("footer");

?>

<!DOCTYPE html>
<html>
<head>
	<title>Adote, não compre!</title>
	<meta charset="utf-8">
	<?php /* Carrega arquivos CSS. */ ?>
	<link rel="stylesheet" type="text/css" href="assets\css\bootstrap.css">
	<link rel="stylesheet" type="text/css" href="asset\login.css">
	
	<?php /* Carrega arquivos Javascript. */ ?>
	<script type="text/javascript" src="assets/js/jquery.js"></script>
	<script type="text/javascript" src="assets\js\bootstrap.min.js"></script> 
	<script type="text/javascript" src="asset/register.js"></script>

</head>
<body>
	<?php
		// Tenta realizar a inserção dos módulos.
	try {
		$navbarModule->toRender("navbar", "raw"); ?>

		<div class="container">
			<?php 
			if($retorno["codigo"] == 0){
				$class = "danger";
			}
			if($retorno["codigo"] == 1){
				$class = "success";
			}
			if($retorno["codigo"] == 2){
				$class = "warning";
			}
			?>
			<div class='alert <?php echo "alert-$class"; ?>'>
				<strong><?php echo $retorno["mensagem"]; ?></strong>
			</div>
			<p>
				<a href="index.php">Voltar a página principal</a>
			</p>
		</div>

		<?php
		$footerModule->toRender("footer", "default");
		// Captura exeções.
	} catch (Exception $e) {
		echo $e->getMessage();
	}
	?>
</body>
</html>