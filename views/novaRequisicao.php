<?php
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');
$pacientes = PacienteController::listar();
$exames = ExameController::listar();
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Requisição</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            padding: 40px;
            color: #fff;
        }

        .container {
            background: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.3);
        }

        .btn-custom {
            background-color: #120428;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #2c1d59;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Nova Requisição</h1>
    <form method="POST" action="../controllers/salvarRequisicao.php">
        <div class="mb-3">
            <label for="paciente_id" class="form-label">Paciente:</label>
            <select class="form-select" id="paciente_id" name="paciente_id" required>
                <option value="">Selecione um paciente</option>
                <?php while ($p = $pacientes->fetch_assoc()): ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                <?php endwhile; ?>
            </select>
            <div class="mt-2">
                <a href="cadastroPacientes.php" class="btn btn-sm btn-secondary">Cadastrar Novo Paciente</a>
            </div>
        </div>
        <div class="mb-3">
            <label for="exames" class="form-label">Exames:</label>
            <?php while ($e = $exames->fetch_assoc()): ?>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="exame_<?= $e['id'] ?>" name="exames[]" value="<?= $e['id'] ?>">
                    <label class="form-check-label" for="exame_<?= $e['id'] ?>">
                        <?= htmlspecialchars($e['nome']) ?>
                    </label>
                </div>
            <?php endwhile; ?>
        </div>
        <div class="d-grid">
            <button type="submit" class="btn btn-custom">Salvar Requisição</button>
        </div>
    </form>
</div>
</body>
</html>