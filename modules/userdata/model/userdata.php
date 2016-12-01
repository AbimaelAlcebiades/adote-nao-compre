<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Usuario;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelUserData {

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
     * @param Usuario $usuario Recebe um objeto Usuario e grava no banco de dados.
     * @return boolean Retorna true se salvou o e false caso algum problema tenha ocorrido.
     */
    public function gravarUsuario(Usuario $usuario) {
        try {

            if ( !is_null($usuario->getId()) ){
                return $this->editar($usuario);
            } else {
                return $this->inserir($usuario);
            }
            
        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }


    public function inserir(Usuario $usuario) {
        try {
            $sql = "
            INSERT INTO usuarios 
            ( nome) 
            VALUES  
            ( :nome)";


            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);

            $preparaSQL->bindValue(":nome", $usuario->getNome());

            return $preparaSQL->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function editar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuarios set
            nome = :nome
            ,email = :email
            ,telefone = :telefone
            ,endereco_completo = :endereco_completo
            ,senha = :senha
            WHERE id = :id";

            $preparaSQL = $this->conexao->prepare($sql);

            //exit(var_dump((int)$usuario->getId()));

            $preparaSQL->bindValue(":id", (int)$usuario->getId(), PDO::PARAM_INT);
            $preparaSQL->bindValue(":nome", $usuario->getNome(), PDO::PARAM_STR);
            $preparaSQL->bindValue(":email", $usuario->getEmail(), PDO::PARAM_STR);
            $preparaSQL->bindValue(":telefone", $usuario->getTelefone(), PDO::PARAM_STR);
            $preparaSQL->bindValue(":endereco_completo", $usuario->getEnderecoCompleto(), PDO::PARAM_STR);
            $preparaSQL->bindValue(":senha", md5($usuario->getSenha()), PDO::PARAM_STR);

            return $preparaSQL->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function deletar($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id = :id";
            //$p_sql = Conexao::getInstance()->prepare($sql);

            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);
            
            $preparaSQL->bindValue(":id", $id);

            return $preparaSQL->execute();
        } catch (Exception $e) {
           print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function buscarPorId($id) {
        try {
            $sql = "SELECT * FROM usuario WHERE id = :id";
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

    public function buscarTodas() {
        try {
            $sql = "SELECT * FROM usuarios ";

            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);
            
            $preparaSQL->execute();
            
            $lista = array();
            while($row = $preparaSQL->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaUsuario($row));
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    private function populaUsuario($registro) 
    {
        $usuario = new Usuario;
        $usuario->setId($registro['id']);
        $usuario->setNome($registro['nome']);
        return $usuario;
    }

}

?>