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
  <script type="text/javascript" src="../../asset/speciedata.js"></script>

</head>
<body>
  <?php
    // Tenta realizar a inserção dos módulos.
  try {
    $navbarModule->toRender("navbar", "raw"); ?>

    <div class="container">
      <div>
        <h1>Meus Cães</h1>
      </div>

      <div class="container">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Cão</th>
              <th>Ação</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>
                Loop
              </td>
              <td>
                <a href="/dog/edit/41" class="btn btn-info" role="button">
                  <span class="glyphicon glyphicon-pencil" aria-hidden="true">&nbsp;</span>Editar
                </a>

                <a class="btn btn-danger" role="button" name="delete" data-id="41">
                  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;</span>Excluir
                </a>
              </td>
            </tr>
          </tbody>
        </table>

        <a href="/dog/create" id="id_add_dog" class="btn btn-success" role="button">
          <span class="glyphicon glyphicon-plus" aria-hidden="true">&nbsp;</span>Adicionar Cão
        </a>

      </div>

      <hr>
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

