<?php
require_once(__DIR__ . '/../controllers/ResultadoController.php');
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');
$resultados = ResultadoController::listar();
$pacientes = PacienteController::listar();
$exames = ExameController::listar();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            padding-top: 70px; /* Espaço para a navbar fixa */
            color: #fff;
            margin: 0; /* Remove margens extras */
        }

        .container {
            background: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.3);
        }

        .btn-salvar {
            background-color: #120428;
            color: #fff;
        }

        .btn-salvar:hover {
            background-color: #2c1d59;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
                <h1 class="text-center mb-0">Lançamento de Resultados de Exames</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="paciente_id" class="form-label">Paciente:</label>
                        <select class="form-select" id="paciente_id" name="paciente_id" required>
                            <option value="">Selecione</option>
                            <?php while ($p = $pacientes->fetch_assoc()): ?>
                                <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nome']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="mb-3">
    <label for="requisicao_id" class="form-label">Requisição:</label>
    <select class="form-select" id="requisicao_id" name="requisicao_id" required>
        <option value="">Selecione uma requisição</option>
        <?php
        $requisicoes = $conn->query("SELECT r.id, r.numero, p.nome AS paciente_nome FROM requisicoes r JOIN paciente p ON r.paciente_id = p.id");
        while ($req = $requisicoes->fetch_assoc()):
        ?>
            <option value="<?= $req['id'] ?>">
                <?= htmlspecialchars('Requisição #' . $req['numero'] . ' - ' . $req['paciente_nome']) ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>
                    <div class="mb-3">
                        <label for="data" class="form-label">Data:</label>
                        <input type="date" class="form-control" id="data" name="data" required>
                    </div>
                    <div class="mb-3">
                        <label for="resultado" class="form-label">Resultado:</label>
                        <textarea class="form-control" id="resultado" name="resultado" rows="3" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="cadastrar_resultado" class="btn btn-primary btn-salvar">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-lg mt-5 border-0">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
                <h2 class="text-center mb-0">Resultados Lançados</h2>
            </div>
            <div class="card-body">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Paciente</th>
                            <th>Exame</th>
                            <th>Data</th>
                            <th>Resultado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultados->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['paciente_nome']) ?></td>
                            <td><?= htmlspecialchars($row['exame_nome']) ?></td>
                            <td><?= htmlspecialchars($row['data']) ?></td>
                            <td><?= htmlspecialchars($row['resultado']) ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>