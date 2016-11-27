<?php

namespace TrabalhoG2;

class Animal {

    private $id;
    private $idRaca;
    private $idUsuario;
    private $nome;
    private $idade;
    private $peso;
    private $sexo;
    private $foto;
    private $informacoes;
    private $adotado;

    public function getId() {
        return $this->id;
    }

    public function setId($idAnimal) {
        $this->id = $idAnimal;
    }

    public function getIdRaca() {
        return $this->idRaca;
    }

    public function setIdRaca($idRaca) {
        $this->idRaca = $idRaca;
    }

    public function getIdUsuario() {
        return $this->idUsuario;
    }

    public function setIdUsuario($idUsuario) {
        $this->idUsuario = $idUsuario;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getIdade() {
        return $this->idade;
    }

    public function setIdade($idade) {
        $this->idade = $idade;
    }
    
    public function getPeso() {
        return $this->peso;
    }

    public function setPeso($peso) {
        $this->peso = $peso;
    }
    
    public function getSexo() {
        return $this->sexo;
    }

    public function setSexo($sexo) {
        $this->sexo = $sexo;
    }    

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }    

    public function getInformacoes() {
        return $this->informacoes;
    }

    public function setInformacoes($informacoes) {
        $this->informacoes = $informacoes;
    }

    public function getAdotado() {
        return $this->adotado;
    }

    public function setAdotado($adotado) {
        $this->adotado = $adotado;
    }    
}

?>