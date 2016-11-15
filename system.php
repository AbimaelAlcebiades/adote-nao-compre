<?php

namespace TrabalhoG2;

// Constantes.
const ROOT_PATH = __DIR__ . "\\";
const MODULES_PATH = ROOT_PATH . 'modules' . "\\";

// USAR AUTOLOAD.
require_once "connection.php";
require_once "classes" . "\\" . "Usuario.php";
require_once "classes" . "\\" . "DaoUsuario.php";
require_once "classes" . "\\" . "Controller.php";

// Adiciona classes a serem utilizadas pelo sistema.
use TrabalhoG2\Connection,
	TrabalhoG2\Usuario,
	TrabalhoG2\DaoUsuario,
	\Exception;


/**
 * Classe principal que realiza execução do sistema.
 */
class System{

	// Variável que armazena conexão para interação com o banco de dados.
	private $connection;

	function __construct(){
		// Instância uma conexão.
		$connection = new Connection();
		// Defini uma conexão.
		$this->connection = $connection->getInstance();
	}
	
	public function execute(){
		$usuario = new Usuario();

		$usuario->setNome("Abimael");
		$usuario->setEmail("abimaelafsilva@gmail.com");
		$usuario->setSenha("senha");

		$daoUsuario = DaoUsuario::getInstance();

		$daoUsuario->inserir($usuario);
	}

	/**
	 * Função que pega controller de um módulo.
	 * @param string $moduleName Nome do módulo a ser carregado.
	 * @return Controller Retorna controller do módulo.
	 */
	public function getModule($moduleName)
	{
		// Configura caminho do modulo solicitado.
		$pathModule = MODULES_PATH;
		// Configura caminho completo do controller do módulo.
		$module = $pathModule . $moduleName . "\\" . "controller" . "\\" . $moduleName . '.php';

		if(file_exists($module)){
			// Realiza a inclusão do arquivo.
			include $module;
		}else{
			// Gera exceção.
			throw new Exception("Erro ao incluir aquivo controller do módulo " . $moduleName);
		}

		// Pega o nome da classe.
		$className =  __NAMESPACE__ . "\\" . "Controller" . ucfirst($moduleName);

		// Instancia um controller do módulo solicitado.
		$controllerModuleInstance =  new $className();

		// Retorna controller do módulo.
		return $controllerModuleInstance;
	}

	/**
	 * Função que carrega o CSS do módulo.
	 * @param Controller $controller Controller que para carregar o CSS.
	 * @return String Retorna código HTML para inserção do script css.
	 */
	public function loadCSS(Controller $controller){
		
		$htmlCSSInsert = '<link rel="stylesheet" type="text/css" href="#cssPath#">';

		$cssPath = $controller->getCSS();

		$htmlCSSInsert = str_replace("#cssPath#", $cssPath, $htmlCSSInsert);

		return $htmlCSSInsert;
	}

	/**
	 * Função que carrega o Javascript do módulo.
	 * @param Controller $controller Controller que para carregar o Javascript.
	 * @return String Retorna código HTML para inserção do script javascript.
	 */
	public function loadJavascript(Controller $controller){
		
		$htmlJavascriptInsert = '<script src=#javascriptPath#></script>';
		$javascriptPath = $controller->getJavascript();
		$htmlJavascriptInsert = str_replace("#javascriptPath#", $javascriptPath, $htmlJavascriptInsert);

		return $htmlJavascriptInsert;
	}
}
?>