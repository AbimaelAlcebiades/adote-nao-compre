<?php

namespace TrabalhoG2;

class Usuario {

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $telefone;
    private $enderecoCompleto;

    public function getId() {
        return $this->id;
    }

    public function setId($idUsuario) {
        $this->id = $idUsuario;
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
        $this->senha = $senha;
    }


    public function getTelefone() {
        return $this->telefone;
    }

    public function setTelefone($telefone) {
        $this->telefone = $telefone;
    }

    public function getEnderecoCompleto() {
        return $this->enderecoCompleto;
    }

    public function setEnderecoCompleto($enderecoCompleto) {
        $this->enderecoCompleto = $enderecoCompleto;
    }        

}

?>