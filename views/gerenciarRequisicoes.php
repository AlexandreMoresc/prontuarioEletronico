<?php
require_once(__DIR__ . '/../controllers/RequisicaoController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');

// Obter todas as requisições para exibição no campo de seleção
$requisicoes = RequisicaoController::listar();
$exames = ExameController::listar();

// Obter o ID da requisição selecionada
$requisicao_id = $_GET['requisicao_id'] ?? null;
$requisicao = $requisicao_id ? RequisicaoController::buscarPorId($requisicao_id) : null;

// Processar o envio do formulário para atualizar ou excluir a requisição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['atualizar_requisicao'])) {
            // Garantir que o paciente_id e exames sejam enviados corretamente
            if (empty($_POST['paciente_id'])) {
                throw new Exception('ID do paciente é obrigatório.');
            }

            $exames_selecionados = $_POST['exames'] ?? []; // Garantir que exames seja um array
            RequisicaoController::atualizar($requisicao_id, $_POST['paciente_id'], $exames_selecionados);
            $mensagem = "Requisição atualizada com sucesso!";
            header("Location: gerenciarRequisicoes.php?requisicao_id=$requisicao_id");
            exit;
        }

        if (isset($_POST['excluir_requisicao'])) {
            // Excluir a requisição
            RequisicaoController::excluir($requisicao_id);
            $mensagem = "Requisição excluída com sucesso!";
            header("Location: gerenciarRequisicoes.php");
            exit;
        }
    } catch (Exception $e) {
        $erro = $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Requisições</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?> <!-- Inclui a barra de navegação -->
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Gerenciar requisições</li>
            </ol>
        </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Gerenciar Requisições</h1>

        <!-- Exibir mensagens de erro ou sucesso -->
        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($erro) ?></div>
        <?php elseif (isset($mensagem)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <!-- Formulário para selecionar a requisição -->
        <form method="GET" action="" class="mb-4">
            <div class="mb-3">
                <label for="requisicao_id" class="form-label">Selecione a Requisição:</label>
                <select name="requisicao_id" id="requisicao_id" class="form-select" required>
                    <option value="">-- Escolha uma Requisição --</option>
                    <?php while ($row = $requisicoes->fetch_assoc()): ?>
                        <option value="<?= $row['id'] ?>" <?= $requisicao_id == $row['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($row['numero']) ?> - <?= htmlspecialchars($row['paciente_nome']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Selecionar</button>
        </form>

        <?php if ($requisicao): ?>
            <h3 class="text-center">Paciente: <?= htmlspecialchars($requisicao['paciente']['paciente_nome']) ?></h3>

            <!-- Formulário para atualizar a requisição -->
            <form method="POST" action="">
                <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($requisicao['paciente']['paciente_id']) ?>">
                <div class="mb-3">
                    <label for="exames" class="form-label">Exames:</label>
                    <?php while ($e = $exames->fetch_assoc()): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="exame_<?= $e['id'] ?>" name="exames[]" value="<?= $e['id'] ?>"
                                <?= in_array($e['id'], array_column($requisicao['exames'], 'id')) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="exame_<?= $e['id'] ?>">
                                <?= htmlspecialchars($e['nome']) ?>
                            </label>
                        </div>
                    <?php endwhile; ?>
                </div>
                <div class="d-grid mb-3">
                    <button type="submit" name="atualizar_requisicao" class="btn btn-primary">Atualizar Requisição</button>
                </div>
            </form>

            <!-- Botão para excluir a requisição -->
            <form method="POST" action="">
                <div class="d-grid">
                    <button type="submit" name="excluir_requisicao" class="btn btn-danger">Excluir Requisição</button>
                </div>
            </form>
        <?php else: ?>
            <p class="text-danger text-center">Nenhuma requisição selecionada.</p>
        <?php endif; ?>
    </div>
</body>
</html>