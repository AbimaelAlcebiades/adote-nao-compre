<?php

namespace TrabalhoG2;

class Usuario {

    private $id;
    private $nome;
    private $email;
    private $senha;

    public function getId() {
        return $this->id;
    }

    public function setId($idUsuario) {
        $this->id = $id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        // Converte todo o e-mail para minúsculo.
        $this->email = strtolower($email);
    }

    // USAR CRIPTOGRAFIA MD5 NO MYSQL PARA ARMAZENAR A SENHA.
    public function getSenha() {
        return $this->senha;
    }

    public function setSenha($senha) {
        $this->senha = strtolower($senha);
    }    

}

?>