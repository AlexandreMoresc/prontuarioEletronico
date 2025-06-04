<?php
require_once(__DIR__ . '/../controllers/PacienteController.php');
PacienteController::cadastrar();
$pacientes = PacienteController::listar();
include 'navbar.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Código para salvar o paciente...
    header('Location: novaRequisicao.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Pacientes</h1>
        <form method="POST" action="">
            <div class="row mb-3">
                <label for="nome" class="col-sm-2 col-form-label">Nome Completo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="nascimento" class="col-sm-2 col-form-label">Data de Nascimento:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="nascimento" name="nascimento" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="cpf" class="col-sm-2 col-form-label">CPF:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="cpf" name="cpf" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="sexo" class="col-sm-2 col-form-label">Sexo:</label>
                <div class="col-sm-10">
                    <select class="form-select" id="sexo" name="sexo" required>
                        <option value="masculino">Masculino</option>
                        <option value="feminino">Feminino</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
            </div>
            <div class="row mb-3">
                <label for="telefone" class="col-sm-2 col-form-label">Telefone:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="telefone" name="telefone" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="email" class="col-sm-2 col-form-label">E-mail:</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="endereco" class="col-sm-2 col-form-label">Endereço Completo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="endereco" name="endereco" required>
                </div>
            </div>
            <div class="row mb-3">
                <label for="convenio" class="col-sm-2 col-form-label">Convênio:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="convenio" name="convenio">
                </div>
            </div>
            <div class="row mb-3">
                <label for="observacoes" class="col-sm-2 col-form-label">Observações Adicionais:</label>
                <div class="col-sm-10">
                    <textarea class="form-control" id="observacoes" name="observacoes"></textarea>
                </div>
            </div>
            <div class="row mb-3 text-center">
                <div class="col">
                    <button type="submit" name="cadastrar" class="btn btn-primary">Cadastrar</button>
                </div>
                <div class="col">
                    <button type="reset" class="btn btn-danger">Limpar</button>
                </div>
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
                <?php while ($row = $pacientes->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['nascimento']) ?></td>
                    <td><?= htmlspecialchars($row['cpf']) ?></td>
                    <td><?= htmlspecialchars($row['telefone']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="#" class="btn btn-warning btn-sm disabled">Editar</a>
                        <a href="#" class="btn btn-danger btn-sm disabled">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
