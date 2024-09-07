<?php
namespace Controller;

include_once __DIR__ . '/../Model/Livro.php';
include_once __DIR__ . '/../Repository/LivroRepository.php';
include_once __DIR__ . '/../db/Database.php';

use Model\Livro;
use Repository\LivroRepository;
use db\Database;


class LivroController {
    private $repository;

    public function __construct() {
        $this->repository = new LivroRepository();
    }

    public function cadastrarLivro($nome, $ano, $idAutor) {
        $livro = new Livro(null, $nome, $ano, $idAutor,1);
        $this->repository->save($livro);
    }

    public function editarLivro($id, $nome, $ano, $idAutor, $disponibilidade) {
        $livro = $this->repository->findById($id);
        if ($livro) {
            $livro->setNome($nome);
            $livro->setAno($ano);
            $livro->setIdAutor($idAutor);
            $livro->setDisponibilidade($disponibilidade);
            $this->repository->save($livro);
        }
    }

    public function excluirLivro($id) {
        $this->repository->delete($id);
    }

    public function listarLivros() {
        return $this->repository->findAll();
    }

    public function getLivroById($id) {
        return $this->repository->findById($id);
    }
}
?>
