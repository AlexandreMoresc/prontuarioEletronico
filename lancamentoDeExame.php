<?php
include 'conexao.php';

$paciente_exame_id = $_GET['paciente_exame_id'];

$sql = "SELECT * FROM paciente_exames WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$paciente_exame_id]);
$paciente_exame = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $valor_exame = $_POST['valor_exame'];
    $unidade_medida = $_POST['unidade_medida'];
    $valor_referencia = $_POST['valor_referencia'];
    $observacoes = $_POST['observacoes'];
    $data_resultado = $_POST['data_resultado'];
    $tecnico_responsavel = $_POST['tecnico_responsavel'];

    $sql_insert = "INSERT INTO resultados (paciente_exame_id, valor_exame, unidade_medida, valor_referencia, observacoes, data_resultado, tecnico_responsavel) 
                   VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert = $pdo->prepare($sql_insert);
    $stmt_insert->execute([$paciente_exame_id, $valor_exame, $unidade_medida, $valor_referencia, $observacoes, $data_resultado, $tecnico_responsavel]);
    
    echo "Resultado registrado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lançar Resultados</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Lançar Resultados do Exame</h1>
    <form method="POST">
        <label for="valor_exame">Valor do Exame:</label>
        <input type="text" name="valor_exame" id="valor_exame" required><br>

        <label for="unidade_medida">Unidade de Medida:</label>
        <input type="text" name="unidade_medida" id="unidade_medida" required><br>

        <label for="valor_referencia">Valor de Referência:</label>
        <input type="text" name="valor_referencia" id="valor_referencia" required><br>

        <label for="observacoes">Observações:</label>
        <textarea name="observacoes" id="observacoes"></textarea><br>

        <label for="data_resultado">Data do Resultado:</label>
        <input type="date" name="data_resultado" id="data_resultado" required><br>

        <label for="tecnico_responsavel">Técnico Responsável:</label>
        <input type="text" name="tecnico_responsavel" id="tecnico_responsavel" required><br>

        <button type="submit">Registrar Resultado</button>
    </form>
</body>
</html>
