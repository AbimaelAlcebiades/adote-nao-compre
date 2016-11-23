<?php

namespace TrabalhoG2;

use \Exception,
	TrabalhoG2\ViewLogin,
	TrabalhoG2\ModelLogin;

/**
* Classe controller do módulo login.
*/
class ControllerLogin implements Controller
{

	// Variáveis da classe.
	private $moduleName;
	private $viewPath;
	private $modelLogin;
	private $javascriptFile;

	/**
	 * Construtor da classe.
	 */
	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Arquivo viewLogin.
		$this->viewLogin = self::getViewPath() . strtolower($this->moduleName) . ".php";
		
		// Arquivo modelLogin.
		$this->modelLogin = self::getModelPath() . strtolower($this->moduleName) . ".php";
		
		// Pega o javascript do módulo.
		$this->javascriptFile = self::getAssetPath() . "login.js";
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
		$className = str_replace("Controller", "", $className);
		// Retorna nome da classe.
		return $className;
	}

	/**
	 * Pega o caminho da view do módulo.
	 * @return string Retorna o diretório "view" do módulo.
	 */
	private function getViewPath()
	{
		// Pega constante com o caminho padrão para o diretório das views.
		$viewPath = self::PATH_VIEW;
		// Configura caminho conforme nome do módulo.
		$viewPath = str_replace("moduleName", self::getModuleName(), $viewPath);
		// Retorna caminho das views.
		return $viewPath;
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
	 * Pega o caminho da assets do módulo.
	 * @return string Retorna o diretório "asset' do módulo.
	 */
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
	 * Renderiza um módulo.
	 * @param string $viewName Nome da view que será chamada.
	 * @param string $templateName Nome do template que será utilizado.
	 */
	public function toRender($viewName, $templateName)
	{
	
		// Instância uma view.
		$viewLogin = self::loadView("login", $this->viewLogin);

		// Inicia sessão.
		session_start();

		// Verifica se existe variável de sessão com usuário logado.
		if(isset($_SESSION["usuarioLogado"])){
			// Exibe template de usuário logado.
			$viewLogin->display("usuarioLogado");
		}else{
			// Exibe outro template solicitado.
			$viewLogin->display($templateName);
		}
	}

	/**
	 * Pega o caminho do javascript do módulo.
	 * @return string Retorna caminho do javascript do módulo.
	 */
	public function getJavascript()
	{
		return $this->javascriptFile;
	}

	/**
	 * Recebe e trata requisições ajax para o módulo.
	 * @param string $dataPost Dados enviados via requisição.
	 * @return mixed Retorno da função solicitada.
	 */
	public function ajaxLogin($dataPost)
	{
		// Pega nome da função que será executada.
		$functionName = $dataPost['data']['functionName'];

		// Variável que armazena retorno da requisição.
		$return = "";

		// Tratamentos para requisições.
		switch ($functionName) {
			
			// Função "toLogin".
			case "toLogin":
				$user =  $dataPost['data']['user'];
				$password =  $dataPost['data']['password'];
				$return = self::toLogin($user, $password);
				break;

			// Função "toExit".
			case "toExit":
				$return = self::toExit();
				break;
			
			// Comportamento padrão.
			default:
				break;
		}

		// Retorna requisição.
		return $return;

	}

	/**
	 * Função que efetua login do usuário.
	 * @param string $user Nome do usuário(e-mail).
	 * @param string $password Senha do usuário.
	 * @return boolean Retorna true se o usuário logou com sucesso ou false caso não tenha logado.
	 */
	public function toLogin($user, $password){

		// Tenta autenticar o usuário.
		$isUsuarioAutenticado = self::autenticaUsuario($user, $password);

		// Se é um usuário autenticado.
		if($isUsuarioAutenticado){

			// Carrega model.
			$modelLogin = self::loadModel("login", $this->modelLogin);

			// Pega usuário.
			$usuario = $modelLogin->buscarUsuario($user);

			// Inicia sessão.
			session_start();

			// Armazena usuário em sessão.
			$_SESSION["usuarioLogado"] = $usuario;

			// Usuário logado.
			return true;
		}else{

			// Usuário não está logado.
			return false;
		}
	}

	/**
	 * Função que desloga um usuário.
	 */
	public function toExit(){

		// "Zera" variável "usuárioLogado".
		$_SESSION["usuarioLogado"] = null;

		// Elimina cookies de sessão.
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
	}

	/**
	 * Função que autentica um usuário, validando usuário e senha passados.
	 * @param string $user Nome do usuário(e-mail).
	 * @param string $password Senha do usuário.
	 * @return boolean Retorna true se a senha e usuário passados são validos ou false caso sejam inválidos.
	 */
	public function autenticaUsuario($user, $password){
		// Criptografa a senha.
		$password = md5($password);

		// Pega DAO do usuário.
		$daoUsuario = DaoUsuario::getInstance();

		// Tenta buscar um usuário.
		$usuario = $daoUsuario->buscarUsuario($user);

		// Verifica se foi encontrado um usuário.
		if($usuario){
			// Verifica se a senha informada corresponde a senha cadastrada para o usuário.
			if($password == $usuario->getSenha()){
				return true;
			}else{
				// Senha incorreta.
				return false;
			}
		}else{
			// Usuário não encontrado.
			return false;
		}
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

}

?>