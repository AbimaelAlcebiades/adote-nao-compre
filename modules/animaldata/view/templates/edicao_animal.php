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
$animalData         = $system->getModule("animaldata");

if(@$_GET["animal"]){
    
  session_start();
  $usuario = $_SESSION['usuarioLogado'];
  $animal = $animalData->buscarPorId($_GET["animal"], $usuario->getId());

}

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

    <div class="container module-highlighthome">

  <h2>Cadastro de animal</h2>
  <br>
  <form class="form-inline" action="/dog/create/" method="post" enctype="multipart/form-data">
    
    <label>Nome (opcional)</label>
    <p><input class="form-control" id="id_Nome" value="<?php echo $animal->getNome(); ?>" maxlength="20" name="Nome" type="text" /></p>

    <label>Espécie</label>
    <p><select class="form-control" id="id_IdRaca" name="idEspecie" required>
      <option value="1" selected="selected">Cachorro</option>
      <option value="2">Gato</option>
    </select></p>


    <label>Raça</label>
    <p><select class="form-control" id="id_IdRaca" name="idRaca" required>
      <option value="1" selected="selected">Sem Raça Definida</option>
      <option value="5">Affenpinscher</option>
      <option value="6">Afghan Hound</option>
      <option value="7">Airedale Terrier</option>
      <option value="8">Akita</option>
      <option value="9">Akita Americano</option>
      <option value="10">American Pit Bull Terrier</option>
    </select></p>
    
    <label>Idade</label>
    <p><input class="form-control" value="<?php echo $animal->getIdade(); ?>" id="id_Idade" name="Idade" type="number" min="0" max="30" /></p>
    
    
    <label>Peso</label>
    <p><input class="form-control" id="id_Peso" value="<?php echo $animal->getPeso(); ?>" name="Peso" step="any" type="number" min="0" required /></p>
    
    <label>Sexo</label>
    <p><select class="form-control" id="id_Sexo" name="Sexo" required>
      <option value="M" selected="selected">Macho</option>
      <option value="F">Femea</option>
    </select></p>

    <label>Foto</label>
    <p>
      <input type="file" class="filestyle" data-icon="false" data-buttonBefore="true" name="Foto" required>
    </p>

    <label>Informações adicionais</label>
    <p><textarea rows="4" cols="50" class="form-control" name="Info" required=""><?php echo $animal->getInformacoes(); ?></textarea></p>

    <button type="submit" class="btn btn-primary">
      <span class="glyphicon glyphicon-floppy-disk" aria-hidden="true">&nbsp;</span>Salvar
    </button>

    <a href="/dog/list" class="btn btn-danger" role="button">
      <span class="glyphicon glyphicon-remove-circle" aria-hidden="true">&nbsp;</span>Cancelar
    </a>
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

