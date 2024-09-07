<?php
namespace Model;

class Livro {
    private $id;
    private $nome;
    private $ano;
    private $idAutor;
    private $disponibilidade;

    public function __construct($id, $nome, $ano, $idAutor, $disponibilidade) {
        $this->id = $id;
        $this->nome = $nome;
        $this->ano = $ano;
        $this->idAutor = $idAutor;
        $this->disponibilidade = $disponibilidade;
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

    public function getAno() {
        return $this->ano;
    }

    public function setAno($ano) {
        return $this->ano = $ano;
    }

    public function getIdAutor() {
        return $this->idAutor;
    }

    public function setIdAutor($idAutor) {
        return $this->idAutor = $idAutor;
    }
    public function getDisponibilidade(){
        return $this->disponibilidade;
    }

    public function setDisponibilidade($disp){
        return $this->disponibilidade = $disp;
    }

}
?>