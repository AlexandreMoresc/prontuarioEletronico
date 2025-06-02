<?php
require_once(__DIR__ . '/../controllers/ResultadoController.php');
require_once(__DIR__ . '/../controllers/PacienteController.php');
require_once(__DIR__ . '/../controllers/ExameController.php');
ResultadoController::cadastrar();
$resultados = ResultadoController::listar();
$pacientes = PacienteController::listar();
$exames = ExameController::listar();
include 'navbar.php';
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Lançamento de Resultados de Exames</h1>
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
            <label for="exame_id" class="form-label">Exame:</label>
            <select class="form-select" id="exame_id" name="exame_id" required>
                <option value="">Selecione</option>
                <?php while ($e = $exames->fetch_assoc()): ?>
                    <option value="<?= $e['id'] ?>"><?= htmlspecialchars($e['nome']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="data" class="form-label">Data:</label>
            <input type="date" class="form-control" id="data" name="data" required>
        </div>
        <div class="mb-3">
            <label for="resultado" class="form-label">Resultado:</label>
            <textarea class="form-control" id="resultado" name="resultado" required></textarea>
        </div>
        <button type="submit" name="cadastrar_resultado" class="btn btn-primary">Cadastrar</button>
    </form>
    <h2 class="text-center mt-5">Resultados Lançados</h2>
    <table class="table table-striped mt-3">
        <thead>
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
