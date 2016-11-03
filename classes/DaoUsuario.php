<?php

namespace TrabalhoG2;

//require_once CAMINHO_RAIZ . "admin/conexao.php";
use TrabalhoG2\Connection;

//require_once CAMINHO_RAIZ . "admin/geralog.php";
//require_once CAMINHO_RAIZ . "admin/entity/perfil/controller_perfil.php";
//require_once "pojo_usuario.php";

class DaoUsuario {

    public static $instance;

    private function __construct(){

    }

    public static function getInstance(){
        if (!isset(self::$instance)){
            self::$instance = new DaoUsuario();
        }

        return self::$instance;
    }

    public function inserir(Usuario $usuario) {
        try {
            $sql = "
                INSERT INTO usuario 
                    ( nome, email, senha) 
                VALUES  
                    ( :nome, :email, :senha)";

            $conexao = new Connection();

            $p_sql = $conexao->getInstance()->prepare($sql);

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

    private function populaUsuario($row) 
    {
        $pojo = new PojoUsuario;
        $pojo->setCod_usuario($row['cod_usuario']);
        $pojo->setNome($row['nome']);
        $pojo->setEmail($row['email']);
        $pojo->setSenha($row['senha']);
        $pojo->setAtivo($row['ativo']);
        $pojo->setPerfil(ControllerPerfil::getInstance()->BuscarPorCOD($row['cod_perfil']));
        return $pojo;
    }


    public function teste()
    {
        echo "master of PHP";
    }
}

?>