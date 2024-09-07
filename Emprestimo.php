<?php
namespace Model;

class Emprestimo {
    private $id;
    private $idLivro;
    private $idEstudante;
    private $dataEmprestimo;
    private $dataDevolucao = null;
    private $status = null;

    public function __construct($id, $idLivro, $idEstudante, $dataEmprestimo, $dataDevolucao, $status) {
        $this->id = $id;
        $this->idLivro = $idLivro;
        $this->idEstudante = $idEstudante;
        $this->dataEmprestimo = $dataEmprestimo;
        $this->dataDevolucao = $dataDevolucao;
        $this->status = $status;
    }

    public function getId() {
        return $this->id;
    }

    public function getIdLivro() {
        return $this->idLivro;
    }

    public function setIdLivro($id){
        return $this->idLivro = $id;
    }

    public function setIdEstudante($id){
        return $this->idEstudante = $id;
    }

    public function getIdEstudante() {
        return $this->idEstudante;
    }

    public function setDataEmprestimo($data) {
        return $this->dataEmprestimo = $data;
    }

    public function getDataEmprestimo() {
        return $this->dataEmprestimo;
    }

    public function setDataDevolucao($data) {
        return $this->dataDevolucao = $data;
    }

    public function getDataDevolucao() {
        return $this->dataDevolucao;
    }
    public function setStatus($status){
        return $this->status = $status;
    }
    public function getStatus(){
        return $this->status;
    }

}
?>