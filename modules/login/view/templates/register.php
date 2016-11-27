<?php 

// Inclue arquivo principal do sistema.
include_once "../../../../system.php"; 

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
	<link rel="stylesheet" type="text/css" href="..\..\..\..\assets\css\bootstrap.css">
	<link rel="stylesheet" type="text/css" href="..\..\asset\login.css">
	
	<?php /* Carrega arquivos Javascript. */ ?>
	<script type="text/javascript" src="../../../../assets/js/jquery.js"></script>
	<script type="text/javascript" src="../../../../assets\js\bootstrap.min.js"></script> 
	<script type="text/javascript" src="../../asset/register.js"></script>

</head>
<body>
	<?php
		// Tenta realizar a inserção dos módulos.
	try {
		$navbarModule->toRender("navbar", "raw"); ?>

		<div class="container module-login">

			<form class="form-horizontal form-register" id="form-register" action="../../../../controller_router.php" method="POST">                    
				<div class="form-group">
					<label for="nome" class="col-sm-2 control-label">Nome<sup>*</sup></label>
					<div class="col-sm-10">
						<input class="form-control" id="nome" name="nome" type="text" value="">
					</div>
				</div>
				<div class="form-group div-email">
					<label for="email" class="col-sm-2 control-label">E-mail<sup>*</sup></label>
					<div class="col-sm-10">
						<input class="form-control" id="email" name="email" type="email">
					</div>
				</div>
				<div class="form-group">
					<label for="senha" class="col-sm-2 control-label">Senha<sup>*</sup></label>
					<div class="col-sm-10">
						<input class="form-control" id="senha" name="senha" type="password">
					</div>
				</div>
				<div class="form-group">
					<label for="senha-confirmar" class="col-sm-2 control-label">Confirmar senha<sup>*</sup></label>
					<div class="col-sm-10">
						<input class="form-control" id="senha-confirmar" name="confirmar-senha" type="password">
					</div>
				</div>

				<div class="col-sm-2"></div>
				<div class="form-group">
				<button type="submit" class="btn btn-primary" id="btn_save">
					<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">&nbsp;</span>Salvar
				</button>
				
				<a href="..\..\..\..\index.php" class="btn btn-danger" role="button">
					<span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;</span>Cancelar
				</a>                    
				</div>

				<input class="hidden" id="task" name="task" type="text" value="login.createUser">    
				<input class="hidden" id="templateRedirect" name="templateRedirect" type="text" value="returnUserRegister">

			</form>
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