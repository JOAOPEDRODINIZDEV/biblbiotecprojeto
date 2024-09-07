<?php
namespace Model;

class Autor {
    private $id;
    private $nome;
    private $paisorigem;

    public function __construct($id, $nome, $paisorigem) {
        $this->id = $id;
        $this->nome = $nome;
        $this->paisorigem = $paisorigem;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        return $this->nome = $nome;
    }

    public function getPaisOrigem() {
        return $this->paisorigem;
    }

    public function setPaisOrigem($paisorigem) {
        return $this->paisorigem = $paisorigem;
    }

}
?>
