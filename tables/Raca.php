<?php

namespace TrabalhoG2;

class Raca {

    private $id;
    private $idEspecie;
    private $nome;

    public function getId() {
        return $this->id;
    }

    public function setId($idUsuario) {
        $this->id = $idUsuario;
    }

    public function getIdEspecie() {
        return $this->idEspecie;
    }

    public function setIdEspecie($idEspecie) {
        $this->idEspecie= $idEspecie;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

}

?>