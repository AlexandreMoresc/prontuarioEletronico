<?php
require_once(__DIR__ . '/../models/Paciente.php');
require_once(__DIR__ . '/../config/db.php');

class PacienteController {
    public static function cadastrar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar'])) {
            $paciente = new Paciente(
                $_POST['nome'],
                $_POST['nascimento'],
                $_POST['cpf'],
                $_POST['sexo'],
                $_POST['telefone'],
                $_POST['email'],
                $_POST['endereco'],
                $_POST['convenio'],
                $_POST['observacoes']
            );
            $dados = $paciente->toArray();
            global $conn;
            $stmt = $conn->prepare("INSERT INTO paciente (nome, nascimento, cpf, sexo, telefone, email, endereco, convenio, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param(
                "sssssssss",
                $dados['nome'],
                $dados['nascimento'],
                $dados['cpf'],
                $dados['sexo'],
                $dados['telefone'],
                $dados['email'],
                $dados['endereco'],
                $dados['convenio'],
                $dados['observacoes']
            );
            $stmt->execute();
            $stmt->close();
        }
    }

    public static function listar() {
        global $conn;
        return $conn->query("SELECT * FROM paciente ORDER BY id DESC");
    }
}