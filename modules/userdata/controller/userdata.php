<?php

namespace TrabalhoG2;

use \Exception,
	TrabalhoG2\ViewUserData,
	TrabalhoG2\ModelUserData,
	TrabalhoG2\Usuario;

/**
* Controller for navbar module.
*/
class ControllerUserData implements Controller
{

	private $moduleName;
	private $viewPath;
	private $modelUserData;
	private $viewUserData;
	private $cssFile;
	private $javascriptFile;

	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Pega a view do módulo.
		$this->view = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Arquivo modelUserData.
		$this->modelUserData = self::getModelPath() . strtolower($this->moduleName) . ".php";

		// Arquivo viewUserData.
		$this->viewUserData = self::getViewPath() . strtolower($this->moduleName) . ".php";

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
	public function ajaxUserData($dataPost)
	{
		// Pega nome da função que será executada.
		$functionName = $dataPost['data']['functionName'];

		// Variável que armazena retorno da requisição.
		$return = "";

		// Tratamentos para requisições.
		switch ($functionName) {
			
			// Executa createUser.
			case "registerUser":
			 	$userId = $dataPost['data']['userId'];
			 	$userName = $dataPost['data']['userName'];
			 	$userEmail = $dataPost['data']['userEmail'];
			 	$userPhone = $dataPost['data']['userPhone'];
			 	$userAddress = $dataPost['data']['userAddress'];
			 	$userPassword = $dataPost['data']['userPassword'];
			 
			 	if($userId == "0"){
			 		// Novo registro.
			 		self::registerUser($userName);
			 	}else{
			 		// Update de registro.
			 		self::updateUser($userId, $userName, $userEmail, $userPhone, $userAddress, $userPassword);
			 	}
			 	break;

			// Executa createUser.
			case "loadUserList":
			 	self::loadUserList();
			 	break;

			// Executa createUser.
			case "deleteUser":
				$idUser = $dataPost['data']['idUser'];
			 	self::deleteUser($idUser);
			 	break;  	
			
			// Comportamento padrão.
			default:
				break;
		}

		// Retorna requisição.
		return $return;

	}

	/**
	 * Função que cria um usuario.
	 * @param string $userName Nome da usuario.
	 * @return boolean Retorna true se a usuario foi criada ou false caso contrario.
	 */
	public function registerUser($userName){
		$retorno = array();

		// Carrega model.
		$modelUserData = self::loadModel("userdata", $this->modelUserData);

		$usuario = new Usuario();
		$usuario->setNome($userName);

		$modelUserData->inserir($usuario);
	}

	/**
	 * Função que altera uma usuario.
	 * @param string $userName Nome da usuario.
	 * @param int $userId Id da usuario.
	 * @return boolean Retorna true se a usuario foi atualizada ou false caso contrario.
	 */
	public function updateUser($userId, $userName, $userEmail, $userPhone, $userAddress, $userPassword){
		$retorno = array();

		// Carrega model.
		$modelUserData = self::loadModel("userdata", $this->modelUserData);

		$usuario = new Usuario();
		$usuario->setId($userId);
		$usuario->setNome($userName);
		$usuario->setEmail($userEmail);
		$usuario->setTelefone($userPhone);
		$usuario->setEnderecoCompleto($userAddress);
		$usuario->setSenha($userPassword);
		
		$modelUserData->editar($usuario);
	}

	/**
	 * Função que deleta uma usuario.
	 * @param string $idUser Id da user.
	 * @return boolean Retorna true se a usuario foi deletada ou false caso contrario.
	 */
	public function deleteUser($idUser){
		$retorno = array();

		// Carrega model.
		$modelUserData = self::loadModel("userdata", $this->modelUserData);

		//$usuario = new Usuario();
		//$usuario->setNome($userName);

		$modelUserData->deletar($idUser);

	}

	/**
	 * Função que carrega lista de usuarios.
	 * @return string Retorna html da listagem.
	 */
	public function loadUserList(){
		
		// Carrega model.
		$viewUserData = self::loadView("userdata", $this->viewUserData);
		$usuarios = array();
		$viewUserData->display("listagem_usuarios");

	}

}

?>