<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Animal;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelAnimal {

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
     * @param animal $animal Recebe um objeto Animal e grava no banco de dados.
     * @return boolean Retorna true se salvou o e false caso algum problema tenha ocorrido.
     */
    public function gravarAnimal(Animal $animal) {
        try {

            if (isset($animal->getId())
                return $this->editar($animal);
            else
                return $this->inserir($animal);
            
        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function inserir(Animal $animal) {
        try {
            $sql = "
                INSERT INTO animais 
                    ( id_raca, id_usuario, nome, idade, peso, sexo, foto, informacoes, adotado ) 
                VALUES  
                    ( :id_raca, :id_usuario, :nome, :idade, :peso, :sexo, :foto, :informacoes, :adotado )";

            $p_sql = $this->conexao->getInstance()->prepare($sql);

            $p_sql->bindValue(":id_raca", $animal->getIdRaca());
            $p_sql->bindValue(":id_usuario", $animal->getIdUsuario());
            $p_sql->bindValue(":nome", $animal->getNome());
            $p_sql->bindValue(":idade", $animal->getIdade());
            $p_sql->bindValue(":peso", $animal->getPeso());
            $p_sql->bindValue(":informacoes", $animal->getInformacoes());
            $p_sql->bindValue(":adotado", $animal->getAdotado());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . 
                $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }
//id_raca, id_usuario, nome, idade, peso, sexo, foto, informacoes, adotado
    public function editar(Animal $animal) {
        try {
            $sql = "UPDATE animais set
            ,id_raca = :id_raca
            ,id_usuario = :id_usuario
            ,nome = :nome
            ,idade = :idade
            ,peso = :peso
            ,sexo = :sexo
            ,foto = :foto
            ,informacoes = :informacoes
            ,adotado = :adotado
            WHERE id = :id";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":id_raca", $animal->getIdRaca());
            $p_sql->bindValue(":id_usuario", $animal->getIdUsuario());
            $p_sql->bindValue(":nome", $animal->getNome());
            $p_sql->bindValue(":idade", $animal->getIdade());
            $p_sql->bindValue(":peso", $animal->getPeso());
            $p_sql->bindValue(":sexo", $animal->getSexo());
            $p_sql->bindValue(":foto", $animal->getFoto());
            $p_sql->bindValue(":informacoes", $animal->getInformacoes());
            $p_sql->bindValue(":adotado", $animal->getAdotado());
            $p_sql->bindValue(":id", $animal->getId());

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
            $sql = "DELETE FROM animais WHERE id = :id";
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
            $sql = "SELECT * FROM animais WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute();
            return $this->populaAnimal($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function buscarTodos() {
        try {
            $sql = "SELECT * FROM animais ";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            
            $lista = array();
            while($row = $p_sql->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaAnimal($row));
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado
            um LOG do mesmo, tente novamente mais tarde.";
            GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
                getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaAnimal($registro) 
    {
        $animal = new Animal;
        $animal->setId($registro['id']);
        $animal->setNome($registro['nome']);
        $animal->setEmail($registro['email']);
        $animal->setSenha($registro['senha']);
        $animal->setTelefone($registro['telefone']);
        $animal->setEnderecoCompleto($registro['endereco_completo']);
        $animal->setAdmin($registro['admin']);
        return $animal;
    }

}

?>