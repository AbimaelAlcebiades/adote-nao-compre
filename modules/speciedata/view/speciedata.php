<?php

namespace TrabalhoG2;

use \Exception;

/**
* View for highlight_home module. 	
*/
class ViewSpecieData implements View
{
	
	private $moduleName;
	private $modelSpecieData;

	/**
	 * Construtor da classe.
	 */
	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();
		// Arquivo modelSpecieData.
		$this->modelSpecieData = self::getModelPath() . strtolower($this->moduleName) . ".php";
	}

	/**
	 * Função que carrega uma model para o módulo.
	 * @return Model Retorna uma model.
	 */
	public function loadModel($modelName, $modelPath){

		// Armazena o arquivo em uma variável.
		$model = $modelPath;

		// Verificar se existe o caminho da model solicitada.
		if(file_exists($model)) {
			// Realiza a requisição do arquivo.
			require_once $model;
		}else{
			// Gera exceção.
			throw new Exception("Erro ao incluir aquivo model do módulo " . $modelName);
		}

		// Pega o nome da classe da model.
		$className =  __NAMESPACE__ . "\\" . "Model" . self::getModuleName();

		// Instância model do módulo.
		$modelModuleInstance =  new $className();

		return $modelModuleInstance;
	}

	/**
	 * Pega o caminho da model do módulo.
	 * @return string Retorna o diretório "model' do módulo.
	 */
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
	 * Traz o nome do módulo a que o controller se refere.
	 * @return string Retorna o nome do módulo da controller.
	 */
	private function getModuleName()
	{
		// Pega o nome da classe sem o "namespace".
		$className = (new \ReflectionClass($this))->getShortName();
		// Remove a palavra "Controller" do nome.
		$className = str_replace("View", "", $className);
		// Retorna nome da classe.
		return $className;
	}

	public function display($templateName)
	{
		if($templateName == "listagem_especies"){
			// Carrega model.
			$modelSpecieData = self::loadModel("speciedata", $this->modelSpecieData);
			$especies = $modelSpecieData->buscarTodas();
		}

		include 'templates' . "\\" . $templateName . '.php'; 
	}
}

?>