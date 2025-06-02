<?php
require_once(__DIR__ . '/../models/Resultado.php');
require_once(__DIR__ . '/../config/db.php');

class ResultadoController {
    public static function cadastrar() {
        global $conn;
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_resultado'])) {
            $resultado = new Resultado(
                $_POST['paciente_id'],
                $_POST['exame_id'],
                $_POST['data'],
                $_POST['resultado']
            );
            $dados = $resultado->toArray();
            $stmt = $conn->prepare("INSERT INTO resultado (paciente_id, exame_id, data, resultado) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $dados['paciente_id'], $dados['exame_id'], $dados['data'], $dados['resultado']);
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function listar() {
        global $conn;
        $sql = "SELECT resultado.*, paciente.nome AS paciente_nome, exame.nome AS exame_nome 
                FROM resultado 
                JOIN paciente ON resultado.paciente_id = paciente.id 
                JOIN exame ON resultado.exame_id = exame.id 
                ORDER BY resultado.id DESC";
        return $conn->query($sql);
    }
}
?>