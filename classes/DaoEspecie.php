<?php

namespace TrabalhoG2;

//require_once CAMINHO_RAIZ . "admin/conexao.php";
use TrabalhoG2\Connection,
    \PDO,
    TrabalhoG2\Especie;

//require_once CAMINHO_RAIZ . "admin/geralog.php";
//require_once CAMINHO_RAIZ . "admin/entity/perfil/controller_perfil.php";
//require_once "pojo_usuario.php";

class DaoEspecie {

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
            self::$instance = new DaoEspecie();
        }

        // Retorna instância.
        return self::$instance;
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
            $sql = "UPDATE especie set
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