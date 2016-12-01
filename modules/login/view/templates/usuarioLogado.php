<div class="navbar-right module-login">

	<form class="navbar-form navbar-right" action="/user/profile/" method="get">
		<?php /* Opções de sair/deslogar */ ?>
		<div class="btn-group dropdown">
			<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
				<?php echo $_SESSION["usuarioLogado"]->getNome();?>
			<span class="caret"></span>
			</button>
			<ul class="dropdown-menu">
				<li><a href="modules/userdata/view/templates/default.php">Perfil</a></li>
				<li><a href="#">Meus cães</a></li>
				<?php if($administrador){ ?>
					<li><a href="modules/speciedata/view/templates/default.php">Cadastro de Espécies</a></li>
				<?php } ?>
				<?php if($administrador){ ?>
					<li><a href="modules/breeddata/view/templates/default.php">Cadastro de Raças</a></li>
				<?php } ?>
				<li role="separator" class="divider"></li>
				<li><a href="#" class="module-login link-sair">sair</a></li>
			</ul>
		</div>		
	</form>
</div>