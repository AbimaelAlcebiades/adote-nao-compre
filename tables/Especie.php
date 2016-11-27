<?php

namespace TrabalhoG2;

class Especie {

    private $id;
    private $nome;

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

}

?>