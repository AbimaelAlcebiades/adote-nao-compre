<?php

namespace TrabalhoG2;

//require_once CAMINHO_RAIZ . "admin/conexao.php";
use TrabalhoG2\Connection,
    \PDO,
    TrabalhoG2\Usuario;

//require_once CAMINHO_RAIZ . "admin/geralog.php";
//require_once CAMINHO_RAIZ . "admin/entity/perfil/controller_perfil.php";
//require_once "pojo_usuario.php";

class DaoUsuario {

    public static $instance;
    private $conexao;

    /**
     * Construtor privado da classe.
     */
    private function __construct(){
        // Instância um objeto conexão.
        $conexao = new Connection();   

        // Pega uma instância de uma conexão.
        $this->conexao = $conexao->getInstance();
    }

    /**
     * Função que pega uma instância da classe, implemente padrão de projeto "Singleton".
     * @return DaoUsuario Retorna uma instância da classe.
     */
    public static function getInstance(){
        
        // Verifica se já existe uma instância da classe.
        if(!isset(self::$instance)){
            // Atribuí a variável uma instância da classe.
            self::$instance = new DaoUsuario();
        }

        // Retorna instância.
        return self::$instance;
    }

    public function inserir(Usuario $usuario) {
        try {
            $sql = "
                INSERT INTO usuario 
                    ( nome, email, senha) 
                VALUES  
                    ( :nome, :email, :senha)";

            //$conexao = new Connection();

            $p_sql = $this->conexao->getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":email", $usuario->getEmail());
            $p_sql->bindValue(":senha", $usuario->getSenha());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . 
                $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function editar(PojoUsuario $usuario) {
        try {
            $sql = "UPDATE usuario set
            nome = :nome,
            email = :email,
            senha = :senha,
            ativo = :ativo,
            cod_perfil = :cod_perfil WHERE cod_usuario = :cod_usuario";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":email", $usuario->getEmail());
            $p_sql->bindValue(":senha", $usuario->getSenha());
            $p_sql->bindValue(":ativo", $usuario->getAtivo());
            $p_sql->bindValue(":cod_perfil", $usuario->getPerfil()->
                getCod_perfil());
            $p_sql->bindValue(":cod_usuario", $usuario->getCod_usuario());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function deletar($cod) {
        try {
            $sql = "DELETE FROM usuario WHERE cod_usuario = :cod";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":cod", $cod);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarPorCOD($cod) {
        try {
            $sql = "SELECT * FROM usuario WHERE cod_usuario = :cod";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":cod", $cod);
            $p_sql->execute();
            return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarUsuario($email) {
        try {

            // SQL.
            $sql = "SELECT * FROM usuarios WHERE email = :email;";
            
            // Prepara consulta SQL.
            $prepareSQL = $this->conexao->prepare($sql);
            
            // Insere valores pesquisados.
            $prepareSQL->bindValue(":email", $email, PDO::PARAM_STR);
            
            // Executa SQL.
            $prepareSQL->execute();
            
            // retorna registro encontrado.
            $registro = $prepareSQL->fetch(PDO::FETCH_ASSOC);

            if($registro){
                return self::populaUsuario($registro);
            }else{
                return false;                
            }

        } catch (Exception $e) {
            //############################ Corrigir.
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaUsuario($registro) 
    {
        $usuario = new Usuario;
        $usuario->setId($registro['id']);
        $usuario->setNome($registro['nome']);
        $usuario->setEmail($registro['email']);
        $usuario->setSenha($registro['senha']);
        $usuario->setTelefone($registro['telefone']);
        $usuario->setEnderecoCompleto($registro['endereco_completo']);
        return $usuario;
    }

}

?>