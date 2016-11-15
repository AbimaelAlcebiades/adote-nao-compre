<?php

// Define namespace do arquivo.
namespace TrabalhoG2;

// Declaração do uso de classes.
use \Exception,
	TrabalhoG2\ViewNavBar;

/**
* Controller for navbar module.
*/
class ControllerNavbar implements Controller
{

	private $moduleName;
	private $view;
	private $model;

	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Pega a view do módulo.
		$this->view = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Pega a model do módulo.
		$this->model = self::getModelPath() . strtolower($this->moduleName) . ".php";
	}

	private function getModuleName()
	{
		// Get class name without namespace.		
		$className = (new \ReflectionClass($this))->getShortName();
		// Remove string "Controller".
		$className = str_replace("Controller", "", $className);

		// Retorna nome da classe.
		return $className;
	}

	private function getViewPath()
	{
		// Pega constante com o caminho padrão para o diretório das views.
		$viewPath = self::PATH_VIEW;
		// Configura caminho conforme nome do módulo.
		$viewPath = str_replace("moduleName", self::getModuleName(), $viewPath);
		// Retorna caminho das views.
		return $viewPath;
	}

	private function getModelPath()
	{
		// Pega constante com o caminho padrão para o diretório das views.
		$modelPath = self::PATH_MODEL;
		// Configura caminho conforme nome do módulo.
		$modelPath = str_replace("moduleName", self::getModuleName(), $modelPath);
		// Retorna caminho das views.
		return $modelPath;
	}

	/**
	 * Renderiza um módulo.
	 * @param string $viewName Nome da view que será chamada.
	 * @param string $templateName Nome do template que será utilizado.
	 */
	public function toRender($viewName, $templateName)
	{
		// Configura caminho do modulo solicitado.
		$view = $this->view;

		if(file_exists($view)){
			// Realiza a requisição do arquivo.
			require_once $view;
		}else{
			// Gera exceção.
			throw new Exception("Erro ao incluir aquivo view do módulo " . $viewName);
		}

		// Pega o nome da classe da view.
		$className =  __NAMESPACE__ . "\\" . "View" . self::getModuleName();

		// Instância view do módulo.
		$viewModuleInstance =  new $className();

		$viewModuleInstance->display($templateName);
	}

}

?>