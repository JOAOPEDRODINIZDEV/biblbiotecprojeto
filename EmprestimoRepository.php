<?php

namespace Repository;

include_once __DIR__ . '/../db/Database.php';
include_once __DIR__ . '/../Model/Emprestimo.php';
include_once __DIR__ . '/../Model/Livro.php';
include_once __DIR__ . '/../Model/Estudante.php';
use Model\Emprestimo;
use db\Database;
use Model\Livro;
use Model\Estudante;

class EmprestimoRepository {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function save(Emprestimo $emprestimo) {
        $conn = $this->db->getConnection();

        if ($emprestimo->getId()) {
            $sql = "UPDATE emprestimo SET idLivro=?, dataDevolucao=?, estatus=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("isii",$emprestimo->getIdLivro(),$emprestimo->getDataDevolucao(), $emprestimo->getStatus(), $emprestimo->getId());
        } else {
            $sql = "INSERT INTO emprestimo (idLivro, idEstudante, dataEmprestimo) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            if ($stmt === false) {
                die('Erro na consulta: ' . $conn->error);
            }
            $stmt->bind_param("iis", $emprestimo->getIdLivro(), $emprestimo->getIdEstudante(), $emprestimo->getDataEmprestimo());
        }

        $stmt->execute();
        $stmt->close();
    }

    public function delete($id) {
        $conn = $this->db->getConnection();
        
        $sql = "DELETE FROM emprestimo WHERE id=?";
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
        
        $sql = "SELECT id, idLivro, idEstudante, dataEmprestimo, dataDevolucao, estatus FROM emprestimo WHERE id=?";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die('Erro na consulta: ' . $conn->error);
        }
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($id, $idLivro, $idEstudante, $dataEmprestimo, $dataDevolucao, $status);

        if ($stmt->fetch()) {
            $stmt->close();
            return new Emprestimo($id, $idLivro, $idEstudante, $dataEmprestimo, $dataDevolucao, $status);
        }

        $stmt->close();
        return null;
    }

    public function findAll() {
        $conn = $this->db->getConnection();
    
        $sql = "SELECT e.id AS idEmprestimo, e.idLivro, e.idEstudante, e.dataEmprestimo, e.dataDevolucao, l.nome AS nomeLivro, s.nome AS nomeEstudante 
        FROM emprestimo e 
        INNER JOIN livro l ON e.idLivro = l.id 
        INNER JOIN estudante s ON e.idEstudante = s.id";
    
        $result = $conn->query($sql);
    
        if ($result === false) {
            die('Erro na execução da consulta: ' . $conn->error);
        }
    
        $emprestimos = [];
        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = $row; // Retorna o array diretamente
        }
    
        $result->free();
        return $emprestimos;
    }

    public function __destruct() {
        $this->db->closeConnection(); // Fecha a conexão quando o objeto for destruído
    }
}
 /*$emprestimos = [];
        while ($row = $result->fetch_assoc()) {
            $emprestimos[] = new Emprestimo($row['id'], $row['idLivro'], $row['idEstudante'], $row['dataEmprestimo'], $row['dataDevolucao']);
        }

        $result->free();
        return $emprestimos;*/
?>
