<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Raca;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelRaca {

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
     * @param Raca $raca Recebe um objeto Raca e grava no banco de dados.
     * @return boolean Retorna true se salvou o e false caso algum problema tenha ocorrido.
     */
    public function gravarRaca(Raca $raca) {
        try {

            if (isset($raca->getId())
                return $this->editar($raca);
            else
                return $this->inserir($raca);
            
        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }


    public function inserir(Raca $raca) {
        try {
            $sql = "
            INSERT INTO racas
            ( nome, id_especie ) 
            VALUES  
            ( :nome, :id_especie )";

            //$conexao = new Connection();

            $p_sql = $this->conexao->getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $raca->getNome());
            $p_sql->bindValue(":id_especie", $raca->getIdEspecie());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . 
                $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function editar(Raca $raca) {
        try {
            $sql = "UPDATE racas set
            nome = :nome
            ,id_especie = :id_especie
            WHERE id = :id";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":nome", $raca->getNome());
            $p_sql->bindValue(":id_especie", $raca->getIdEspecie());
            $p_sql->bindValue(":id", $raca->getId());

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
            $sql = "DELETE FROM racas WHERE id = :id";
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
            $sql = "SELECT * FROM racas WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->populaRaca($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarTodas() {
        try {
            $sql = "SELECT * FROM racas ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            
            $lista = array();
            while($row = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaRaca($row));
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaRaca($registro) 
    {
        $raca = new Raca;
        $raca->setId($registro['id']);
        $raca->setIdEspecie($registro['id_especie']);
        $raca->setNome($registro['nome']);
        return $raca;
    }

}

?>