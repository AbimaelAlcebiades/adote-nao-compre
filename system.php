<?php

// Define namespace do arquivo.
namespace TrabalhoG2;

// Constantes do sistema.
const ROOT_PATH = __DIR__ . "\\";
const MODULES_PATH = ROOT_PATH . 'modules' . "\\";

//****** USAR AUTOLOAD, (IMPLEMENTAR AUTOLOAD PARA CARREGAR CLASSES).
require_once "classes" . "\\" . "connection.php";
require_once "classes" . "\\" . "Usuario.php";
require_once "classes" . "\\" . "DaoUsuario.php";
require_once "classes" . "\\" . "Controller.php";

// Declaração do uso de classes.
use TrabalhoG2\Connection,
	TrabalhoG2\Usuario,
	TrabalhoG2\DaoUsuario,
	\Exception;


/**
 * Classe principal do sistema.
 */
class System{

	// Variável que armazena conexão para interação com o banco de dados.
	private $connection;

	function __construct(){
		// Instância uma conexão com o banco de dados.
		$connection = new Connection();
		// Define uma conexão.
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
			// Realiza a inclusão do arquivo, apenas se não existir ainda.
			include_once $module;
		}else{
			// Gera exceção.
			throw new Exception("Erro ao incluir aquivo controller do módulo " . $moduleName);
		}

		// Pega o nome da classe.
		$className =  __NAMESPACE__ . "\\" . "Controller" . ucfirst($moduleName);

		// Instância um controller do módulo solicitado.
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
	 * @param string $moduleName Nome do módulo.
	 * @param string $scriptName Nome do script.
	 * @return String Retorna código HTML para inserção do script javascript.
	 */
	public function loadJavascript($moduleName, $scriptName){

		$modulo = self::getModule($moduleName);
		
		$htmlJavascriptInsert = '<script src=#javascriptPath#></script>';
		$javascriptPath = $modulo->getJavascript();
		$htmlJavascriptInsert = str_replace("#javascriptPath#", $javascriptPath, $htmlJavascriptInsert);

		return $htmlJavascriptInsert;
	}


	public function executeAjaxModuleFunction($moduleName){

		$module = self::getModule($moduleName);

		$function = "ajax$moduleName";

		return $module->$function($_POST);
	}
}
?>