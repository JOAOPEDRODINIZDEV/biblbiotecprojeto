<?php
namespace Controller;

include_once __DIR__ . '/../Model/Emprestimo.php';
include_once __DIR__ . '/../Repository/EmprestimoRepository.php';
include_once __DIR__ . '/../db/Database.php';

use Model\Emprestimo;
use Repository\EmprestimoRepository;
use db\Database;


class EmprestimoController {
    private $repository;

    public function __construct() {
        $this->repository = new EmprestimoRepository();
    }

    public function cadastrarEmprestimo($idLivro, $idEstudante, $dataEmprestimo, $dataDevolucao, $status) {
        $emprestimo = new Emprestimo(null, $idLivro, $idEstudante, $dataEmprestimo, $dataDevolucao, $status);
        $this->repository->save($emprestimo);
    }

    public function editarEmprestimo($id,$idLivro,$dataDevolucao, $status) {
        $emprestimo = $this->repository->findById($id);
        if ($emprestimo) {
            $emprestimo->setDataDevolucao($dataDevolucao);
            $emprestimo->setStatus($status);
            $this->repository->save($emprestimo);
        }
    }

    public function excluirEmprestimo($id) {
        $this->repository->delete($id);
    }

    public function listarEmprestimos() {
        return $this->repository->findAll();
    }

    public function getEmprestimoById($id) {
        return $this->repository->findById($id);
    }
}
?>
