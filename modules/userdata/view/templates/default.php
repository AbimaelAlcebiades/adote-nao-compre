<?php 

// Inclue arquivo principal do sistema.
include_once "../../../../system.php"; 

// Declaração do uso de classes.
use TrabalhoG2\System;

// Inicia o sistema.
$system = New System();

// Carrega módulos.
$navbarModule       = $system->getModule("navbar"); 
$footerModule       = $system->getModule("footer");

// Inicia sessão.
session_start();

// Carrega usuário logado
$user = $_SESSION["usuarioLogado"];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Adote, não compre!</title>
  <meta charset="utf-8">
  <?php /* Carrega arquivos CSS. */ ?>
  <link rel="stylesheet" type="text/css" href="..\..\..\..\assets\css\bootstrap.css">
  <link rel="stylesheet" type="text/css" href="..\..\asset\default.css">
  
  <?php /* Carrega arquivos Javascript. */ ?>
  <script type="text/javascript" src="../../../../assets/js/jquery.js"></script>
  <script type="text/javascript" src="../../../../assets\js\bootstrap.min.js"></script> 
  <script type="text/javascript" src="../../asset/userdata.js"></script>

</head>
<body>
  <?php
    // Tenta realizar a inserção dos módulos.
  try {
    $navbarModule->toRender("navbar", "raw"); ?>

    <div class="container module-userdata">
      <h3 class="titulo_cadastro">Editar Perfil</h3>
      <form class="form-horizontal form-userdata" id="form-register" action="" method="POST">                    
        <div class="form-group row">
          <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $user->getId();?>">
          <label for="nome_user" class="col-sm-2 control-label">Nome<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control nome_usuario" id="nome_usuario" name="nome_usuario" type="text" value="<?php echo $user->getNome();?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="email_usuario" class="col-sm-2 control-label">E-mail<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control email_usuario" id="email_usuario" name="email_usuario" type="text" value="<?php echo $user->getEmail();?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="telefone_usuario" class="col-sm-2 control-label">Telefone<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control telefone_usuario" id="telefone_usuario" name="telefone_usuario" type="text" value="<?php echo $user->getTelefone();?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="endereco_usuario" class="col-sm-2 control-label">Endereço completo<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control endereco_usuario" id="endereco_usuario" name="endereco_usuario" type="text" value="<?php echo $user->getEnderecoCompleto();?>">
          </div>
        </div>
        <div class="form-group row">
          <label for="senha_usuario" class="col-sm-2 control-label">Senha<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control senha_usuario" id="senha_usuario" name="senha_usuario" type="password" value="">
          </div>
        </div>
        <div class="form-group row">
          <label for="senha2_usuario" class="col-sm-2 control-label">Confirmar senha<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control senha2_usuario" id="senha2_usuario" name="senha2_usuario" type="password" value="">
          </div>
        </div>

    <div class="form-group botoes">
      <button type="submit" class="btn btn-primary enviar-formulario" id="btn_save">
        <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">&nbsp;</span>Salvar
    </button>
    <a href="..\..\..\..\index.php" class="btn btn-danger btn-cancel" role="button">
        <span class="glyphicon glyphicon-remove-circle cancelar" aria-hidden="true">&nbsp;</span>Cancelar
    </a>                   
    </div>

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