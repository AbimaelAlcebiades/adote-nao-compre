<?php

// Inclue arquivo principal do sistema.
include_once "system.php"; 

// Declaração do uso de classes.
use TrabalhoG2\System;

// Pega nome do módulo e task.
$task = $_POST['task'];
$task = explode('.', $task);
$moduleName = $task[0];
$functionName = $task[1];

// Inicia o sistema.
$system = New System();

// Realiza rota para controler e função.
$system->executeControllerModule($moduleName);

?>