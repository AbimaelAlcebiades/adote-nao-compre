<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
\PDO,
TrabalhoG2\Animal;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelAnimalData {

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

            if ($animal->getId()){
                return $this->editar($animal);
            }
            else{
                return $this->inserir($animal);
            }
            
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

            $preparaSQL = $this->conexao->prepare($sql);

            $preparaSQL->bindValue(":id_raca", $animal->getIdRaca());
            $preparaSQL->bindValue(":id_usuario", $animal->getIdUsuario());
            $preparaSQL->bindValue(":nome", $animal->getNome());
            $preparaSQL->bindValue(":idade", $animal->getIdade());
            $preparaSQL->bindValue(":peso", $animal->getPeso());
            $preparaSQL->bindValue(":sexo", $animal->getSexo());
            $preparaSQL->bindValue(":foto", $animal->getFoto());
            $preparaSQL->bindValue(":informacoes", $animal->getInformacoes());
            $preparaSQL->bindValue(":adotado", $animal->getAdotado());

            return $preparaSQL->execute();
        } catch (Exception $e) {
            print  $e->getCode() . " Mensagem: " . $e->getMessage();
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

    public function buscarPorId($id, $idUser) {
        try {
            $sql = "
            SELECT
                *
            FROM
                animais 
            WHERE id = :id AND id_usuario = :id_usuario";
            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);
 
            $preparaSQL->bindValue(":id", $id, PDO::PARAM_INT);
             $preparaSQL->bindValue(":id_usuario", $idUser, PDO::PARAM_INT);
            $preparaSQL->execute();
            return $this->populaAnimal($preparaSQL->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
             print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function buscarTodasRacas($idEspecie) {
        try {
            $sql = "SELECT * FROM racas where id_especie = :id_especie";

            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);
            $preparaSQL->bindValue(":id_especie", $idEspecie, PDO::PARAM_INT);
            
            $preparaSQL->execute();
            
            $lista = array();

            while($row = $preparaSQL->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $row);
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    public function buscarTodos($idUsuario = false) {
        try {
            if($idUsuario == false){
                $sql = "SELECT * FROM animais ";
            }else{
                $sql = "SELECT * FROM animais WHERE id_usuario = :id_usuario";
            }

            $preparaSQL = $this->conexao->prepare($sql);
            
            $preparaSQL->bindValue(":id_usuario", $idUsuario, PDO::PARAM_INT);
            
            $preparaSQL->execute();
            
            $lista = array();
            while($row = $preparaSQL->fetch(PDO::FETCH_ASSOC)) {
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
        $animal->setIdRaca($registro['id_raca']);
        $animal->setIdUsuario($registro['id_usuario']);
        $animal->setNome($registro['nome']);
        $animal->setIdade($registro['idade']);
        $animal->setPeso($registro['peso']);
        $animal->setSexo($registro['sexo']);
        $animal->setFoto($registro['foto']);
        $animal->setInformacoes($registro['informacoes']);
        $animal->setAdotado($registro['adotado']);
        return $animal;
    }

    public function buscarTodasEspecies() {
        try {
            $sql = "SELECT * FROM especies ";

            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);
            
            $preparaSQL->execute();
            
            $lista = array();
            while($row = $preparaSQL->fetch(PDO::FETCH_ASSOC)) {
                array_push($lista, $this->populaEspecie($row));
            }

            return $lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação Erro: Código: "
            . $e->getCode() . " Mensagem: " . $e->getMessage();
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