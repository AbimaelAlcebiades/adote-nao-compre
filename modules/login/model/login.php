<?php

namespace TrabalhoG2;

// Inclue classes necessárias.
use TrabalhoG2\Connection,
    \PDO,
    TrabalhoG2\Usuario;

/**
 * Classe model, realizar interações com o banco de dados.
 */
class ModelLogin {

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
     * Função que cria um usuário no banco de dados.
     * @param Usuario $usuario Recebe um objeto usuário e insere no banco de dados.
     * @return boolean Retorna true se salvou o usuário e false caso algum problema tenha ocorrido.
     */
    public function criarUsuario(Usuario $usuario) {
        try {
            $sql = "
                INSERT INTO usuarios 
                    ( nome, email, senha) 
                VALUES  
                    ( :nome, :email, :senha)";

            // Trata consulta SQL.
            $preparaSQL = $this->conexao->prepare($sql);

            // Realiza "bind"(substituição) dos valores.
            $preparaSQL->bindValue(":nome", $usuario->getNome());
            $preparaSQL->bindValue(":email", $usuario->getEmail());
            $preparaSQL->bindValue(":senha", md5($usuario->getSenha()));

            // Realiza execução do SQL.
            $resultado = $preparaSQL->execute();

            // Retorna resultado.
            return $resultado;

        } catch (Exception $e) {
            // Retorna se algum erro ocorreu.
            return  "Erro: Código: " . $e->getCode() . " Mensagem: " . $e->getMessage();
        }
    }

    // public function editar(PojoUsuario $usuario) {
    //     try {
    //         $sql = "UPDATE usuario set
    //         nome = :nome,
    //         email = :email,
    //         senha = :senha,
    //         ativo = :ativo,
    //         cod_perfil = :cod_perfil WHERE cod_usuario = :cod_usuario";

    //         $p_sql = Conexao::getInstance()->prepare($sql);

    //         $p_sql->bindValue(":nome", $usuario->getNome());
    //         $p_sql->bindValue(":email", $usuario->getEmail());
    //         $p_sql->bindValue(":senha", $usuario->getSenha());
    //         $p_sql->bindValue(":ativo", $usuario->getAtivo());
    //         $p_sql->bindValue(":cod_perfil", $usuario->getPerfil()->
    //             getCod_perfil());
    //         $p_sql->bindValue(":cod_usuario", $usuario->getCod_usuario());

    //         return $p_sql->execute();
    //     } catch (Exception $e) {
    //         print "Ocorreu um erro ao tentar executar esta ação, foi gerado
    //         um LOG do mesmo, tente novamente mais tarde.";
    //         GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
    //             getCode() . " Mensagem: " . $e->getMessage());
    //     }
    // }

    // public function deletar($cod) {
    //     try {
    //         $sql = "DELETE FROM usuario WHERE cod_usuario = :cod";
    //         $p_sql = Conexao::getInstance()->prepare($sql);
    //         $p_sql->bindValue(":cod", $cod);

    //         return $p_sql->execute();
    //     } catch (Exception $e) {
    //         print "Ocorreu um erro ao tentar executar esta ação, foi gerado
    //         um LOG do mesmo, tente novamente mais tarde.";
    //         GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
    //             getCode() . " Mensagem: " . $e->getMessage());
    //     }
    // }

    // public function buscarPorCOD($cod) {
    //     try {
    //         $sql = "SELECT * FROM usuario WHERE cod_usuario = :cod";
    //         $p_sql = Conexao::getInstance()->prepare($sql);
    //         $p_sql->bindValue(":cod", $cod);
    //         $p_sql->execute();
    //         return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
    //     } catch (Exception $e) {
    //         print "Ocorreu um erro ao tentar executar esta ação, foi gerado
    //         um LOG do mesmo, tente novamente mais tarde.";
    //         GeraLog::getInstance()->inserirLog("Erro: Código: " . $e->
    //             getCode() . " Mensagem: " . $e->getMessage());
    //     }
    // }

    /**
     * Função para buscar um usuário.
     * @param string $email Email do usuário a ser procurado no banco de dados.
     * @return Usuario|boolean Retorna dados do usuário, caso não seja encontrado retorna false.
     */
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