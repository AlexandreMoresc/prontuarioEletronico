<?php
require_once(__DIR__ . '/../config/db.php');

if (isset($_GET['requisicao_id'])) {
    $requisicao_id = intval($_GET['requisicao_id']);

    // Buscar os dados do paciente
    $stmt = $conn->prepare("SELECT p.nome AS paciente_nome FROM requisicoes r JOIN paciente p ON r.paciente_id = p.id WHERE r.id = ?");
    $stmt->bind_param("i", $requisicao_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paciente = $result->fetch_assoc();
    $stmt->close();

    // Buscar os exames relacionados à requisição
    $stmt = $conn->prepare("SELECT e.nome AS exame_nome FROM requisicao_exames re JOIN exame e ON re.exame_id = e.id WHERE re.requisicao_id = ?");
    $stmt->bind_param("i", $requisicao_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $exames = [];
    while ($row = $result->fetch_assoc()) {
        $exames[] = $row['exame_nome'];
    }
    $stmt->close();

    // Retornar os dados em formato JSON
    echo json_encode([
        'paciente' => $paciente,
        'exames' => $exames
    ]);
    exit;
}