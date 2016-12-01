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
  <script type="text/javascript" src="../../asset/breeddata.js"></script>

</head>
<body>
  <?php
    // Tenta realizar a inserção dos módulos.
  try {
    $navbarModule->toRender("navbar", "raw"); ?>

    <div class="container module-breeddata">
      <h3 class="titulo_cadastro">Nova Raça</h3>
      <h3 class="titulo_edicao hidden">Editar Raça</h3>
      <form class="form-horizontal form-breeddata" id="form-register" action="" method="POST">                    
        <div class="form-group row">
          <label for="nome_raca" class="col-sm-2 control-label">Nome<sup>*</sup></label>
          <div class="col-sm-10">
            <input class="form-control nome_raca" id="nome_raca" name="nome_raca" type="text" value="">
          </div>
        </div>
        <div class="form-group row">
          <label for="id_especie" class="col-sm-2 control-label">Espécie<sup>*</sup></label>
          <div class="col-sm-10">
            <select class="form-control id_especie" id="id_especie" name="id_especie" type="text" value="">
            </select>
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
      <div class="listagem-racas">
      </div>
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