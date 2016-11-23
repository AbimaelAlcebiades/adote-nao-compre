<?php

// Inclue arquivo principal do sistema.
include_once "system.php"; 

// Declaração do uso de classes.
use TrabalhoG2\System;

// Pega nome do módulo.
$moduleName = $_POST['moduleName'];

// Inicia o sistema.
$system = New System();

exit($system->executeAjaxModuleFunction($moduleName));

?>