<?php

// Define namespace do arquivo.
namespace TrabalhoG2;

// Constantes do sistema.
const ROOT_PATH = __DIR__ . "\\";
const MODULES_PATH = ROOT_PATH . 'modules' . "\\";

//****** USAR AUTOLOAD, (IMPLEMENTAR AUTOLOAD PARA CARREGAR CLASSES).
require_once "classes" . "\\" . "Connection.php";
require_once "tables" . "\\" . "Usuario.php";
require_once "tables" . "\\" . "Especie.php";
require_once "tables" . "\\" . "Raca.php";
require_once "classes" . "\\" . "Controller.php";
require_once "classes" . "\\" . "View.php";

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

	// Metódo construtor da classe.
	function __construct(){
		// Instância uma conexão com o banco de dados.
		$connection = new Connection();
		// Define uma conexão.
		$this->connection = $connection->getInstance();
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
		
		// Template de HTML.
		$htmlCSSInsert = '<link rel="stylesheet" type="text/css" href="#cssPath#">';
		// Pega caminho do CSS.
		$cssPath = $controller->getCSS();
		// Realiza replace no template HTML.
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

		// Pega o módulo.
		$modulo = self::getModule($moduleName);
		// Template de HTML.
		$htmlJavascriptInsert = '<script src=#javascriptPath#></script>';
		// Pega caminho do javascript.
		$javascriptPath = $modulo->getJavascript();
		// Realiza replace no template HTML.
		$htmlJavascriptInsert = str_replace("#javascriptPath#", $javascriptPath, $htmlJavascriptInsert);

		return $htmlJavascriptInsert;
	}

	/**
	 * Função que recebe e direciona requisições ajax para o módulo correto.
	 * @param string $moduleName Nome do módulo que vai receber a requisição.
	 * @return Retorna uma chamada para o módulo.
	 */
	public function executeAjaxModuleFunction($moduleName){

		// Pega o módulo.
		$module = self::getModule($moduleName);
		// Nome padrão da função.
		$function = "ajax$moduleName";
		// Retorna função passando post capturado.
		return $module->$function($_POST);
	}


	/**
	 * Funçãi que recebe e trata execuções de controllers.
	 * @param string $moduleName Nome do módulo.
	 * @return Retorna uma chamada para o módulo.
	 */
	public function executeControllerModule($moduleName){

		// Pega o módulo.
		$module = self::getModule($moduleName);
		// Nome padrão da função.
		$function = "controllerExecute$moduleName";
		// Retorna função passando post capturado.
		return $module->$function($_POST);
	}
}
?>