<?php
require_once(__DIR__ . '/../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = intval($_POST['paciente_id']);
    $exames = $_POST['exames'] ?? [];

    if (empty($paciente_id) || empty($exames)) {
        die('Paciente e exames são obrigatórios.');
    }

    // Inserir a requisição no banco de dados
    $stmt = $conn->prepare("INSERT INTO requisicoes (paciente_id, data) VALUES (?, NOW())");
    $stmt->bind_param("i", $paciente_id);
    $stmt->execute();
    $requisicao_id = $stmt->insert_id; // ID da requisição gerado automaticamente
    $stmt->close();

    // Inserir os exames relacionados à requisição
    $stmt = $conn->prepare("INSERT INTO requisicao_exames (requisicao_id, exame_id) VALUES (?, ?)");
    foreach ($exames as $exame_id) {
        $stmt->bind_param("ii", $requisicao_id, $exame_id);
        $stmt->execute();
    }
    $stmt->close();

    // Redirecionar para a página inicial ou outra página
    header('Location: ../views/home.php');
    exit;
}