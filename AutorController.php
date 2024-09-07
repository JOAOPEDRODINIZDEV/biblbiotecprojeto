<?php
namespace Controller;

include_once __DIR__ . '/../Model/Autor.php';
include_once __DIR__ . '/../Repository/AutorRepository.php';
include_once __DIR__ . '/../db/Database.php';

use Model\Autor;
use Repository\AutorRepository;
use db\Database;


class AutorController {
    private $repository;

    public function __construct() {
        $this->repository = new AutorRepository();
    }

    public function cadastrarAutor($nome, $paisorigem) {
        $autor = new Autor(null, $nome, $paisorigem);
        $this->repository->save($autor);
    }

    public function editarAutor($id, $nome, $paisorigem) {
        $autor = $this->repository->findById($id);
        if ($autor) {
            $autor->setNome($nome);
            $autor->setPaisOrigem($paisorigem);
            $this->repository->save($autor);
        }
    }

    public function excluirAutor($id) {
        $this->repository->delete($id);
    }

    public function listarAutores() {
        return $this->repository->findAll();
    }

    public function getAutorById($id) {
        return $this->repository->findById($id);
    }
}
?>
