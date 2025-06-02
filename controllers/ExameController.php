<?php
require_once(__DIR__ . '/../models/Exame.php');
require_once(__DIR__ . '/../config/db.php');

class ExameController {
    public static function cadastrar() {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_exame'])) {
            $exame = new Exame($_POST['nome'], $_POST['descricao']);
            $dados = $exame->toArray();
            $stmt = $conn->prepare("INSERT INTO exame (nome, descricao) VALUES (?, ?)");
            $stmt->bind_param("ss", $dados['nome'], $dados['descricao']);
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function listar() {
        global $conn;
        return $conn->query("SELECT * FROM exame ORDER BY id DESC");
    }
}
?>