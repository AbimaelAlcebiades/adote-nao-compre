<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Especie;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelEspecie {

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
     * @param Especie $especie Recebe um objeto Especie e grava no banco de dados.
     * @return boolean Retorna true se salvou o e false caso algum problema tenha ocorrido.
     */
    public function gravarEspecie(Especie $especie) {
        try {

            if (isset($especie->getId())
                return $this->editar($especie);
            else
                return $this->inserir($especie);
            
        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }


    public function inserir(Especie $especie) {
        try {
            $sql = "
            INSERT INTO especie 
            ( nome) 
            VALUES  
            ( :nome)";

            //$conexao = new Connection();

            $p_sql = $this->conexao->getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $especie->getNome());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . 
                $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function editar(Especie $especie) {
        try {
            $sql = "UPDATE especies set
            nome = :nome,
            WHERE id = :id";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $especie->getNome());
            $p_sql->bindValue(":id", $especie->getId());

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
            $sql = "DELETE FROM especie WHERE id = :id";
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
            $sql = "SELECT * FROM especie WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->populaEspecie($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarTodas() {
        try {
            $sql = "SELECT * FROM especie ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            
            $lista = array();
            while($row = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaEspecie($row));
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaEspecie($registro) 
    {
        $especie = new Especie;
        $especie->setId($registro['id']);
        $especie->setNome($registro['nome']);
        return $especie;
    }

}

?>