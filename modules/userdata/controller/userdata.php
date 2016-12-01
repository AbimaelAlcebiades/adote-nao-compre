<?php

namespace TrabalhoG2;

use \Exception,
	ViewUserData;

/**
* Controller for navbar module.
*/
class ControllerUserData implements Controller
{

	private $moduleName;
	private $view;
	private $model;
	private $cssFile;

	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Pega a view do módulo.
		$this->view = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Pega a model do módulo.
		$this->model = self::getModelPath() . strtolower($this->moduleName) . ".php";

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
     * Recebe e trata execuções de controllers para o módulo.
     * @param string $dataPost Dados enviados para a controller.
     * @return mixed Retorno da função solicitada.
     */
    public function controllerExecuteUserData($dataPost)
    {
        // Pega nome da função que será executada.
        $functionName = explode(".", $dataPost['task']);
        $functionName = $functionName[1];

        // Tratamentos para requisições.
        switch ($functionName) {
            
            // Executa createUser.
            case "createUserData":
                $id = $dataPost['id'];
                $nome = $dataPost['nome'];
                $email =  $dataPost['email'];
                $senha =  $dataPost['senha'];
                $telefone =  $dataPost['telefone'];
                $endereco_completo = $dataPost['endereco_completo'];

                $templateRedirect = @$dataPost['templateRedirect'];

                self::createUser($id, $nome, $email, $senha, $telefone, $endereco_completo, $templateRedirect);
                break;
            
            // Comportamento padrão.
            default:
                break;
        }
    }

    /**
     * Função que grava o usuário.
     * @param string $name Nome do usuário.
     * @param string $email Email do usuário(usuário).
     * @param string $password Senha do usuário.
     * @return boolean Retorna true se o usuário foi criado com sucesso ou false caso contrario.
     */
    public function createUser($id, $nome, $email, $senha, $telefone, $endereco_completo, $templateRedirect = false){
        $retorno = array();

        // Carrega model.
        $model = self::loadModel("userdata", $this->model);

    
        $usuario =  new Usuario();
		$usuario->setId($id);
        $usuario->setNome($nome);
        $usuario->setEmail($email);
        $usuario->setSenha($senha);
        $usuario->setTelefone($telefone);
        $usuario->setEnderecoCompleto($endereco_completo);

        // grava usuário no banco de dados.
        $resultado = $model->gravarUsuario($usuario);

        if($resultado){
            $retorno["codigo"] = 1;
            $retorno["mensagem"] = "Dados salvos com sucesso";
        }else{
            $retorno["codigo"] = 0;
            $retorno["mensagem"] = "Ocorreu um erro ao salvar o usuário";
        }

        if($templateRedirect){
            // Retornar template.
            exit(include "modules/login/view/templates/$templateRedirect.php");
        }else{
            return $resultado;
        }

    }

    /**
	 * Função que atualiza um usuario.
	 * @param string $breedName Nome da raça.
	 * @return boolean Retorna true se a raça foi criada ou false caso contrario.
	 */
	public function updateUser($id, $name, $email, $phone, $address, $password){
		$retorno = array();

		// Carrega model.
		$modelUserData = self::loadModel("userdata", $this->modelUserData);

		$user = new Usuario();
		$user->setId($id);
		$user->setNome($name);
		$user->setEmail($email);
		$user->setTelefone($phone);
		$user->setEnderecoCompleto($address);
		$user->setSenha($password);

		$modelUserData->editar($user);
	}

}

?>