<?php

namespace Repository;

include_once __DIR__ . '/../db/Database.php';
include_once __DIR__ . '/../Model/Livro.php';
use Model\Livro;
use db\Database;

class LivroRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function save(Livro $livro) {
        $conn = $this->db->getConnection();

        if ($livro->getId()) {
            $sql = "UPDATE livro SET nome=?, ano=?, idAutor=?, disponibilidade=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("siiii", $livro->getNome(), $livro->getAno(), $livro->getIdAutor(), $livro->getDisponibilidade(), $livro->getId());
        } else {
            $sql = "INSERT INTO livro (nome, ano, idAutor, disponibilidade) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("ssii", $livro->getNome(), $livro->getAno(), $livro->getIdAutor(), $livro->getDisponibilidade());
        }

        $stmt->execute();
        $stmt->close();
    }

    public function delete($id) {
        $conn = $this->db->getConnection();
        
        $sql = "DELETE FROM livro WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function findById($id) {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id, nome, ano, idAutor, disponibilidade FROM livro WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $ano, $idAutor, $disponibilidade);

        if ($stmt->fetch()) {
            $stmt->close();
            return new Livro($id, $nome, $ano, $idAutor, $disponibilidade);
        }

        $stmt->close();
        return null;
    }

    public function findAll() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id, nome, ano, idAutor, disponibilidade FROM livro";
        $result = $conn->query($sql);

        if ($result === false) {
            die('Erro na execução da consulta: ' . $conn->error);
        }

        $livros = [];
        while ($row = $result->fetch_assoc()) {
            $livros[] = new Livro($row['id'], $row['nome'], $row['ano'], $row['idAutor'], $row['disponibilidade']);
        }

        $result->free();
        return $livros;
    }

    public function __destruct() {
        $this->db->closeConnection(); // Fecha a conexão quando o objeto for destruído
    }
}
?>
