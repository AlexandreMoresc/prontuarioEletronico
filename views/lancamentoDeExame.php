<?php
require_once(__DIR__ . '/../config/db.php');
require_once(__DIR__ . '/../controllers/ResultadoController.php');
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');

$resultados = ResultadoController::listar();
$pacientes = PacienteController::listar();
$exames = ExameController::listar();

$paciente = null;
$exames_da_requisicao = [];
$resultados_visuais = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requisicao_id'])) {
    $requisicao_id = intval($_POST['requisicao_id']);

    // Buscar os dados do paciente
    $stmt = $conn->prepare("SELECT p.nome AS paciente_nome FROM requisicoes r JOIN paciente p ON r.paciente_id = p.id WHERE r.id = ?");
    $stmt->bind_param("i", $requisicao_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $paciente = $result->fetch_assoc();
    $stmt->close();

    // Buscar os exames relacionados à requisição
    $stmt = $conn->prepare("SELECT e.id AS exame_id, e.nome AS exame_nome FROM requisicao_exames re JOIN exame e ON re.exame_id = e.id WHERE re.requisicao_id = ?");
    $stmt->bind_param("i", $requisicao_id);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $exames_da_requisicao[] = $row;
    }
    $stmt->close();
}

// Capturar os resultados enviados pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['exames'])) {
    $resultados_visuais = $_POST['exames'];
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamento de Resultados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-gradient text-white" style="background: linear-gradient(to right, #6a11cb, #2575fc);">
                <h1 class="text-center mb-0">Lançamento de Resultados de Exames</h1>
            </div>
            <div class="card-body">
                <form method="POST" action="lancamentoDeExame.php">
                    <div class="mb-3">
                        <label for="requisicao_id" class="form-label">Requisição:</label>
                        <select class="form-select" id="requisicao_id" name="requisicao_id" required onchange="this.form.submit()">
                            <option value="">Selecione uma requisição</option>
                            <?php
                            $requisicoes = $conn->query("SELECT r.id, r.numero FROM requisicoes r");
                            while ($req = $requisicoes->fetch_assoc()):
                            ?>
                                <option value="<?= $req['id'] ?>" <?= isset($_POST['requisicao_id']) && $_POST['requisicao_id'] == $req['id'] ? 'selected' : '' ?>>
                                    Requisição #<?= $req['numero'] ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </form>

                <div class="mb-3">
                    <label class="form-label">Paciente:</label>
                    <p><?= $paciente ? htmlspecialchars($paciente['paciente_nome']) : 'Selecione uma requisição para carregar os dados.' ?></p>
                </div>

                <form method="POST" action="lancamentoDeExame.php">
                    <input type="hidden" name="requisicao_id" value="<?= isset($requisicao_id) ? $requisicao_id : '' ?>">
                    <div class="mb-3">
                        <label class="form-label">Exames:</label>
                        <ul>
                            <?php if (!empty($exames_da_requisicao)): ?>
                                <?php foreach ($exames_da_requisicao as $exame): ?>
                                    <li>
                                        <strong><?= htmlspecialchars($exame['exame_nome']) ?></strong>
                                        <input type="hidden" name="exames[<?= $exame['exame_id'] ?>][nome]" value="<?= htmlspecialchars($exame['exame_nome']) ?>">
                                        <textarea class="form-control mt-2" name="exames[<?= $exame['exame_id'] ?>][resultado]" rows="2" placeholder="Digite o resultado para este exame" required></textarea>
                                    </li>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <li>Selecione uma requisição para carregar os exames.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="d-grid">
                        <button type="submit" name="cadastrar_resultados" class="btn btn-primary btn-salvar">Salvar Resultados</button>
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
                        <?php if (!empty($resultados_visuais)): ?>
                            <?php foreach ($resultados_visuais as $exame_id => $dados_exame): ?>
                                <tr>
                                    <td><?= htmlspecialchars($paciente['paciente_nome']) ?></td>
                                    <td><?= htmlspecialchars($dados_exame['nome']) ?></td>
                                    <td><?= date('Y-m-d') ?></td>
                                    <td><?= htmlspecialchars($dados_exame['resultado']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <?php while ($row = $resultados->fetch_assoc()): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['paciente_nome']) ?></td>
                                    <td><?= htmlspecialchars($row['exame_nome']) ?></td>
                                    <td><?= htmlspecialchars($row['data']) ?></td>
                                    <td><?= htmlspecialchars($row['resultado']) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>