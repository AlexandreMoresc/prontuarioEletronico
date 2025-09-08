<?php
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../dao/PacienteApiDao.php'); // Inclui o novo DAO

$paciente_para_editar = null;
$modo_edicao = false;

if (isset($_GET['editar'])) {
    $id_para_editar = (int)$_GET['editar'];
    $pacienteDao = new PacienteApiDao();
    $paciente_para_editar = $pacienteDao->buscarPorId($id_para_editar);
    
    if ($paciente_para_editar) {
        $modo_edicao = true;
    }
}

// Mensagens de feedback
$mensagem = '';
if (isset($_GET['msg'])) {
    $msg_map = [
        'cadastrado_sucesso' => ['text' => 'Paciente cadastrado com sucesso!', 'type' => 'success'],
        'atualizado_sucesso' => ['text' => 'Paciente atualizado com sucesso!', 'type' => 'success'],
        'excluido_sucesso' => ['text' => 'Paciente excluído com sucesso!', 'type' => 'success'],
        'erro_cadastrar' => ['text' => 'Erro ao cadastrar paciente.', 'type' => 'danger'],
        'erro_atualizar' => ['text' => 'Erro ao atualizar paciente.', 'type' => 'danger'],
        'erro_excluir' => ['text' => 'Erro ao excluir paciente.', 'type' => 'danger'],
    ];
    if(isset($msg_map[$_GET['msg']])) {
        $mensagem = $msg_map[$_GET['msg']];
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mt-3">
                <li class="breadcrumb-item"><a href="home.php">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pacientes</li>
            </ol>
        </nav>
        
        <?php if ($mensagem): ?>
            <div class="alert alert-<?= $mensagem['type'] ?>"><?= htmlspecialchars($mensagem['text']) ?></div>
        <?php endif; ?>

        <h1 class="text-center mb-4"><?= $modo_edicao ? 'Editar Paciente' : 'Cadastro de Pacientes' ?></h1>
        <form method="POST" action="../controllers/PacienteController.php">
            <?php if ($modo_edicao): ?>
                <input type="hidden" name="id" value="<?= $paciente_para_editar->getId() ?>">
            <?php endif; ?>
            <div class="row mb-3">
                <label for="nome" class="col-sm-2 col-form-label">Nome Completo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= $modo_edicao ? htmlspecialchars($paciente_para_editar->getNome()) : '' ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="nascimento" class="col-sm-2 col-form-label">Data de Nascimento:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="nascimento" name="nascimento" value="<?= $modo_edicao ? htmlspecialchars($paciente_para_editar->getDataNascimento()) : '' ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="cpf" class="col-sm-2 col-form-label">CPF:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $modo_edicao ? htmlspecialchars($paciente_para_editar->getCpf()) : '' ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="telefone" class="col-sm-2 col-form-label">Telefone:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $modo_edicao ? htmlspecialchars($paciente_para_editar->getTelefone()) : '' ?>" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">E-mail:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" value="<?= $modo_edicao ? htmlspecialchars($paciente_para_editar->getEmail()) : '' ?>" required>
                </div>
            </div>
            
            <div class="row mb-3 text-center">
                <div class="col">
                    <button type="submit" name="<?= $modo_edicao ? 'editar' : 'cadastrar' ?>" class="btn btn-primary"><?= $modo_edicao ? 'Salvar Alterações' : 'Cadastrar' ?></button>
                </div>
                <?php if (!$modo_edicao): ?>
                <div class="col">
                    <button type="reset" class="btn btn-danger">Limpar</button>
                </div>
                <?php endif; ?>
            </div>
        </form>

        <h2 class="text-center mt-5">Pacientes Cadastrados</h2>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Data de Nascimento</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php listarPacientesApi(); ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>