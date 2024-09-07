<?php

namespace Repository;

require_once __DIR__ . '/../db/Database.php';
include_once __DIR__ . '/../Model/Estudante.php';
use Model\Estudante;
use db\Database;

class EstudanteRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function save(Estudante $estudante) {
        $conn = $this->db->getConnection();

        if ($estudante->getId()) {
            $sql = "UPDATE estudante SET nome=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("si", $estudante->getNome(), $estudante->getId());
        } else {
            $sql = "INSERT INTO estudante (nome) VALUES (?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("s", $estudante->getNome());
        }

        $stmt->execute();
        $stmt->close();
    }

    public function delete($id) {
        $conn = $this->db->getConnection();
        
        $sql = "DELETE FROM estudante WHERE id=?";
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
        
        $sql = "SELECT id, nome FROM estudante WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $nome);

        if ($stmt->fetch()) {
            $stmt->close();
            return new Estudante($id, $nome);
        }

        $stmt->close();
        return null;
    }

    public function findAll() {
        $conn = $this->db->getConnection();
        
        $sql = "SELECT id, nome FROM estudante";
        $result = $conn->query($sql);

        if ($result === false) {
            die('Erro na execução da consulta: ' . $conn->error);
        }

        $estudantes = [];
        while ($row = $result->fetch_assoc()) {
            $estudantes[] = new Estudante($row['id'], $row['nome']);
        }

        $result->free();
        return $estudantes;
    }

    public function __destruct() {
        $this->db->closeConnection(); // Fecha a conexão quando o objeto for destruído
    }
}
?>
