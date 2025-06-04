<?php
require_once(__DIR__ . '/../config/db.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $stmt = $conn->prepare("INSERT INTO exame (nome, descricao) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $descricao);
    if ($stmt->execute()) {
        $mensagem = "Exame cadastrado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar o exame.";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Exames</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Exames</h1>
        <?php if (isset($mensagem)): ?>
            <div class="alert alert-info"><?= $mensagem ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome do Exame:</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="3"></textarea>
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-custom">Cadastrar Exame</button>
            </div>
        </form>
    </div>
</body>
</html>