<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Usuario;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelUsuario {

    //public static $instance;
    private $conexao;

    /**
     * Construtor da classe.
     */
    function __construct(){
        // Instância um objeto conexão.
        $conexao = new Connection();   

        // Pega uma instância de uma conexão.
        $this->conexao = $conexao->getInstance();
    }

    /**
     * Grava o registro na base independente se ele já existe ou ainda não;
     * @param usuario $usuario Recebe um objeto Usuario e grava no banco de dados.
     * @return boolean Retorna true se salvou o e false caso algum problema tenha ocorrido.
     */
    public function gravarUsuario(Usuario $usuario) {
        try {

            if (isset($usuario->getId())
                return $this->editar($usuario);
            else
                return $this->inserir($usuario);
            
        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function inserir(Usuario $usuario) {
        try {
            $sql = "
                INSERT INTO usuarios 
                    ( nome, email, senha, telefone, endereco_completo, admin) 
                VALUES  
                    ( :nome, :email, :senha, :telefone, :endereco_completo, :admin)";

            $p_sql = $this->conexao->getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":email", $usuario->getEmail());
            $p_sql->bindValue(":senha", $usuario->getSenha());
            $p_sql->bindValue(":telefone", $usuario->getTelefone());
            $p_sql->bindValue(":endereco_completo", $usuario->getEnderecoCompleto());
            $p_sql->bindValue(":admin", $usuario->getAdmin());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . 
                $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function editar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuarios set
            nome = :nome
            ,email = :email
            ,senha = :senha
            ,telefone = :telefone
            ,endereco_completo = :endereco_completo
            ,admin = :admin
            WHERE id = :id";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $usuario->getNome());
            $p_sql->bindValue(":email", $usuario->getEmail());
            $p_sql->bindValue(":senha", $usuario->getSenha());
            $p_sql->bindValue(":telefone", $usuario->getTelefone());
            $p_sql->bindValue(":endereco_completo", $usuario->getEnderecoCompleto());
            $p_sql->bindValue(":admin", $usuario->getAdmin());
            $p_sql->bindValue(":id", $usuario->getId());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM usuarios WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarTodos() {
        try {
            $sql = "SELECT * FROM usuarios ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            
            $lista = array();
            while($row = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaUsuario($row));
            }

            return $lista;
        } catch (Exception $e) {
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
        $usuario->setAdmin($registro['admin']);
        return $usuario;
    }

}

?>