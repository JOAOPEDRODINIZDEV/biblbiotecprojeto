<?php

namespace Repository;

include_once __DIR__ . '/../db/Database.php';
include_once __DIR__ . '/../Model/Autor.php';
use Model\Autor;
use db\Database;

class AutorRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function save(Autor $autor) {
        $conn = $this->db->getConnection();

        if ($autor->getId()) {
            $sql = "UPDATE autor SET nome=?, paisorigem=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("ssi", $autor->getNome(), $autor->getPaisOrigem(), $autor->getId());
        } else {
            $sql = "INSERT INTO autor (nome, paisorigem) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("ss", $autor->getNome(), $autor->getPaisOrigem());
        }

        $stmt->execute();
        $stmt->close();
    }

    public function delete($id) {
        $conn = $this->db->getConnection();
        
        $sql = "DELETE FROM autor WHERE id=?";
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
        
        $sql = "SELECT id, nome, paisorigem FROM autor WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $nome, $paisorigem);

        if ($stmt->fetch()) {
            $stmt->close();
            return new Autor($id, $nome, $paisorigem);
        }

        $stmt->close();
        return null;
    }

    public function findAll() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id, nome, paisorigem FROM autor";
        $result = $conn->query($sql);

        if ($result === false) {
            die('Erro na execução da consulta: ' . $conn->error);
        }

        $autores = [];
        while ($row = $result->fetch_assoc()) {
            $autores[] = new Autor($row['id'], $row['nome'], $row['paisorigem']);
        }

        $result->free();
        return $autores;
    }

    public function __destruct() {
        $this->db->closeConnection(); // Fecha a conexão quando o objeto for destruído
    }
}
?>
