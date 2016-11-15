<?php 

// Carrega instância do sistema.
use TrabalhoG2\System;
$system = new System();
// Carrega modulo login.
$login = $system->getModule("login");


?>
<nav class="navbar navbar-inverse navbar-static-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Adote, não compre!</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<?php 
			 	// Tenta realizar a inserção dos módulos.
				try {
					// Renderiza módulo de login.
					$login->toRender("login", "default");			
				// Captura exeções.
				} catch (Exception $e) {
					echo $e->getMessage();
				}
			?>		
		</div>
	</div>
</nav>