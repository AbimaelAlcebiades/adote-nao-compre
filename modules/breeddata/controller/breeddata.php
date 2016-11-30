<?php

namespace TrabalhoG2;

use \Exception,
	TrabalhoG2\ViewBreedData,
	TrabalhoG2\ModelBreedData,
	TrabalhoG2\Raca;

/**
* Controller for navbar module.
*/
class ControllerBreedData implements Controller
{

	private $moduleName;
	private $viewPath;
	private $modelBreedData;
	private $viewBreedData;
	private $cssFile;
	private $javascriptFile;

	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Pega a view do módulo.
		$this->view = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Arquivo modelBreedData.
		$this->modelBreedData = self::getModelPath() . strtolower($this->moduleName) . ".php";

		// Arquivo viewBreedData.
		$this->viewBreedData = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Pega o css do módulo.
		$this->cssFile = self::getAssetPath() . "default.css";
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
		$viewPath = str_replace("moduleName", strtolower($this->moduleName), $viewPath);
		// Retorna caminho das views.
		return $viewPath;
	}

	private function getModelPath()
	{
		// Pega constante com o caminho padrão para o diretório das models.
		$modelPath = self::PATH_MODEL;
		// Configura caminho conforme nome do módulo.
		$modelPath = str_replace("moduleName", strtolower($this->moduleName), $modelPath);
		// Retorna caminho das views.
		return $modelPath;
	}

	private function getAssetPath()
	{
		// Pega constante com o caminho padrão para o diretório de assets.
		$assetRelativePath = self::PATH_ASSET;
		// Configura caminho conforme nome do módulo.
		$assetRelativePath = str_replace("moduleName", strtolower($this->moduleName), $assetRelativePath);
		// Retorna caminho das views.
		return $assetRelativePath;
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
	 * Função que carrega uma view para o módulo.
	 * @return View Retorna uma view.
	 */
	public function loadView($viewName, $viewPath){

		// Armazena o arquivo em uma variável.
		$view = $viewPath;

		// Verificar se existe o caminho da view solicitada.
		if(file_exists($view)) {
			// Realiza a requisição do arquivo.
			require_once $view;
		}else{
			// Gera exceção.
			throw new Exception("Erro ao incluir aquivo view do módulo " . $viewName);
		}

		// Pega o nome da classe da view.
		$className =  __NAMESPACE__ . "\\" . "View" . self::getModuleName();

		// Instância model do módulo.
		$viewModuleInstance =  new $className();

		return $viewModuleInstance;
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

	public function getCSS()
	{
		return $this->cssFile;
	}

	/**
	 * Recebe e trata requisições ajax para o módulo.
	 * @param string $dataPost Dados enviados via requisição.
	 * @return mixed Retorno da função solicitada.
	 */
	public function ajaxBreedData($dataPost)
	{
		// Pega nome da função que será executada.
		$functionName = $dataPost['data']['functionName'];

		// Variável que armazena retorno da requisição.
		$return = "";

		// Tratamentos para requisições.
		switch ($functionName) {
			
			// Executa createUser.
			case "registerBreed":
			 	$breedName = $dataPost['data']['breedName'];
			 	$breedId = $dataPost['data']['breedId'];
			 
			 	if($breedId == "0"){
			 		// Novo registro.
			 		self::registerBreed($breedName);
			 	}else{
			 		// Update de registro.
			 		self::updateBreed($breedName, $breedId);
			 	}
			 	break;

			// Executa createUser.
			case "loadBreedList":
			 	self::loadBreedList();
			 	break;

			// Executa createUser.
			case "deleteBreed":
				$idBreed = $dataPost['data']['idBreed'];
			 	self::deleteBreed($idBreed);
			 	break;  	
			
			// Comportamento padrão.
			default:
				break;
		}

		// Retorna requisição.
		return $return;

	}

	/**
	 * Função que cria uma raça.
	 * @param string $breedName Nome da raça.
	 * @return boolean Retorna true se a raça foi criada ou false caso contrario.
	 */
	public function registerBreed($breedName, $idSpecie){
		$retorno = array();

		// Carrega model.
		$modelBreedData = self::loadModel("breeddata", $this->modelBreedData);

		$raca = new Raca();
		$raca->setNome($breedName);
		$raca->setIdEspecie($idSpecie);

		$modelBreedData->inserir($raca);
	}

	/**
	 * Função que altera uma raça.
	 * @param string $breedName Nome da raça.
	 * @param int $breedId Id da raça.
	 * @return boolean Retorna true se a raça foi atualizada ou false caso contrario.
	 */
	public function updateBreed($breedName, $breedId){
		$retorno = array();

		// Carrega model.
		$modelBreedData = self::loadModel("breeddata", $this->modelBreedData);

		$raca = new Raca();
		$raca->setNome($breedName);
		$raca->setId($breedId);
		
		$modelBreedData->editar($raca);

	}

	/**
	 * Função que deleta uma raça.
	 * @param string $idBreed Id da breed.
	 * @return boolean Retorna true se a raça foi deletada ou false caso contrario.
	 */
	public function deleteBreed($idBreed){
		$retorno = array();

		// Carrega model.
		$modelBreedData = self::loadModel("breeddata", $this->modelBreedData);

		//$raca = new Raca();
		//$raca->setNome($breedName);

		$modelBreedData->deletar($idBreed);

	}

	/**
	 * Função que carrega lista de raças.
	 * @return string Retorna html da listagem.
	 */
	public function loadBreedList(){
		
		// Carrega model.
		$viewBreedData = self::loadView("breeddata", $this->viewBreedData);
		$racas = array();
		$viewBreedData->display("listagem_racas");

	}

}

?>