<?php

namespace TrabalhoG2;

use \Exception,
	ViewAnimalData;

/**
* Controller for navbar module.
*/
class ControllerAnimalData implements Controller
{

	private $moduleName;
	private $view;
	private $model;
	private $cssFile;
	private $modelAnimalData;

	function __construct()
	{
		// Pega o nome da classe.	
		$this->moduleName = self::getModuleName();

		// Pega a view do módulo.
		$this->view = self::getViewPath() . strtolower($this->moduleName) . ".php";

		// Pega a model do módulo.
		$this->model = self::getModelPath() . strtolower($this->moduleName) . ".php";

		// Arquivo modelAnimalData.
		$this->modelAnimalData = self::getModelPath() . strtolower($this->moduleName) . ".php";

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

	/**
	 * Recebe e trata requisições ajax para o módulo.
	 * @param string $dataPost Dados enviados via requisição.
	 * @return mixed Retorno da função solicitada.
	 */
	public function ajaxAnimalData($dataPost)
	{
		// Pega nome da função que será executada.
		$functionName = $dataPost['data']['functionName'];

		// Variável que armazena retorno da requisição.
		$return = "";

		// Tratamentos para requisições.
		switch ($functionName) {
			
			// Executa createUser.
			case "loadRacaList":
			 	$idEspecie = $dataPost['data']['idEspecie'];
			 	self::loadRacaList($idEspecie);
			 	break;
			
			// Comportamento padrão.
			default:
				break;
		}

		// Retorna requisição.
		return $return;

	}

	/**
	 * Função que carrega lista de especies.
	 * @return string Retorna todas as especies cadastradas no banco de dados.
	 */
	public function loadRacaList($idSpecie){
		
		// Carrega model.
		$modelAnimalData = self::loadModel("animaldata", $this->modelAnimalData);

		$resultado = $modelAnimalData->buscarTodasRacas($idSpecie);

		exit(json_encode($resultado));

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
    public function controllerExecuteAnimalData($dataPost)
    {
        // Pega nome da função que será executada.
        $functionName = explode(".", $dataPost['task']);
        $functionName = $functionName[1];

        // Tratamentos para requisições.
        switch ($functionName) {
            //id_raca, id_usuario, nome, idade, peso, sexo, foto, informacoes, adotado
            // Executa createAnimalData.
            case "createAnimalData":
                $id = $dataPost['id'];
                $id_raca = $dataPost['id_raca'];
                $id_usuario = $dataPost['id_usuario'];
                $nome = $dataPost['nome'];
                $idade = $dataPost['idade'];
                $peso = $dataPost['peso'];
                $sexo = $dataPost['sexo'];
                $foto = $dataPost['foto'];
                $informacoes = $dataPost['informacoes'];
                $adotado = $dataPost['adotado'];

                $templateRedirect = @$dataPost['templateRedirect'];

                self::createAnimal($id, $id_raca, $id_usuario, $nome, $idade, $peso, $sexo, $foto, $informacoes, $adotado, $templateRedirect);
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
    public function createAnimal($id, $id_raca, $id_usuario, $nome, $idade, $peso, $sexo, $foto, $informacoes, $adotado, $templateRedirect = false){
        $retorno = array();

        // Carrega model.
        $model = self::loadModel("animaldata", $this->model);

        $animal =  new Animal();
		$animal->setId($id);
		$animal->setIdRaca($id_raca);
		$animal->setIdUsuario($id_usuario);
        $animal->setNome($nome);
        $animal->setIdade($idade);
        $animal->setPeso($peso);
        $animal->setSexo($sexo);
        $animal->setFoto($foto);
        $animal->setInformacoes($informacoes);
        $animal->setAdotado($adotado);

        // grava raça no banco de dados.
        $resultado = $model->gravarAnimal($animal);

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
	 * Função que carrega lista de especies.
	 * @return string Retorna html da listagem.
	 */
	public function loadAnimalList(){
		
		// Carrega model.
		$ViewAnimalData = self::loadView("speciedata", $this->ViewAnimalData);
		$especies = array();
		$ViewAnimalData->display("listagem_animais");
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
	 * Função que carrega registro de um animal.
	 * @return Array retorna um registro de animal.
	 */
	public function buscarPorId($id, $idUsuario){
		
		// Carrega model.
		$modelAnimalData = self::loadModel("speciedata", $this->modelAnimalData);

		// Pega usuário.
		$animal = $modelAnimalData->buscarPorId($id, $idUsuario);

		return $animal;
	}

	public function inserir(Animal $animal){
		// Carrega model.
		$modelAnimalData = self::loadModel("speciedata", $this->modelAnimalData);

		$modelAnimalData->inserir($animal);
	}

	/**
	 * Função que carrega lista de especies.
	 * @return string Retorna html da listagem.
	 */
	public function loadSpecieList(){
		
		// Carrega model.
		$modelAnimalData = self::loadModel("speciedata", $this->modelAnimalData);

		return $modelAnimalData->buscarTodasEspecies();
	}

}

?>