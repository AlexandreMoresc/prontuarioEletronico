<?php
// REMOVEMOS O CONTROLLER ANTIGO E USAMOS O DAO DA API DIRETAMENTE
require_once(__DIR__ . '/../dao/PacienteApiDao.php');
require_once(__DIR__ . '/../controllers/ExameController.php');
require_once(__DIR__ . '/../controllers/RequisicaoController.php');

// Instanciamos o DAO para buscar os pacientes da API
$pacienteDao = new PacienteApiDao();
$pacientes = $pacienteDao->read(); // O método read() agora retorna os objetos de paciente

$exames = ExameController::listar();

$requisicao_id = $_GET['requisicao_id'] ?? null;
$requisicao = $requisicao_id ? RequisicaoController::buscarPorId($requisicao_id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['salvar_requisicao'])) {
    try {
        if ($requisicao_id) {
            RequisicaoController::atualizar($requisicao_id, $_POST['paciente_id'], $_POST['exames']);
            $mensagem = "Requisição atualizada com sucesso!";
        } else {
            RequisicaoController::salvar($_POST['paciente_id'], $_POST['exames']);
            $mensagem = "Requisição criada com sucesso!";
        }
        header("Location: novaRequisicao.php");
        exit;
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
    <title><?= $requisicao_id ? 'Editar Requisição' : 'Nova Requisição' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nova requisição</li>
                <li class="breadcrumb-item"><a href="gerenciarRequisicoes.php">Gerenciar requisicoes</a></li>
            </ol>
        </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4"><?= $requisicao_id ? 'Editar Requisição' : 'Nova Requisição' ?></h1>

        <?php if (isset($erro)): ?>
            <div class="alert alert-danger text-center"><?= htmlspecialchars($erro) ?></div>
        <?php elseif (isset($mensagem)): ?>
            <div class="alert alert-success text-center"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="paciente_id" class="form-label">Paciente:</label>
                <select class="form-select" id="paciente_id" name="paciente_id" required>
                    <option value="">Selecione um paciente</option>
                    <?php foreach ($pacientes as $p): ?>
                        <option value="<?= $p->getId() ?>" <?= $requisicao && $requisicao['paciente']['id'] == $p->getId() ? 'selected' : '' ?>>
                            <?= htmlspecialchars($p->getNome()) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="mt-2">
                    <a href="cadastroPacientes.php" class="btn btn-sm btn-secondary">Cadastrar Novo Paciente</a>
                </div>
            </div>
            <div class="mb-3">
                <label for="exames" class="form-label">Exames:</label>
                <?php while ($e = $exames->fetch_assoc()): ?>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="exame_<?= $e['id'] ?>" name="exames[]" value="<?= $e['id'] ?>"
                            <?= $requisicao && in_array($e['id'], array_column($requisicao['exames'], 'id')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="exame_<?= $e['id'] ?>">
                            <?= htmlspecialchars($e['nome']) ?>
                        </label>
                    </div>
                <?php endwhile; ?>
            </div>
            <div class="d-grid">
                <button type="submit" name="salvar_requisicao" class="btn btn-custom"><?= $requisicao_id ? 'Atualizar Requisição' : 'Salvar Requisição' ?></button>
            </div>
        </form>
    </div>
</body>
</html>