<?php
// Simulação de pacientes e exames
$pacientes = [
    1 => 'João da Silva',
    2 => 'Maria Oliveira',
    3 => 'Carlos Souza'
];

$exames_agendados = [
    1 => ['Ferro', 'Glicose'],
    2 => ['Colesterol Total'],
    3 => ['GGT', 'Creatinina', 'Sodio']
];

$mensagem = '';
$resultados = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paciente_id = $_POST['paciente'] ?? null;
    $data_resultado = $_POST['data_resultado'] ?? '';
    $tecnico_responsavel = $_POST['tecnico_responsavel'] ?? '';

    if ($paciente_id && isset($exames_agendados[$paciente_id])) {
        foreach ($exames_agendados[$paciente_id] as $index => $exame_nome) {
            $resultados[] = [
                'exame' => $exame_nome,
                'valor' => $_POST['valor_exame'][$index] ?? '',
                'unidade' => $_POST['unidade_medida'][$index] ?? '',
                'referencia' => $_POST['valor_referencia'][$index] ?? '',
                'observacoes' => $_POST['observacoes'][$index] ?? ''
            ];
        }

        $mensagem = "Resultados registrados com sucesso! (Simulação)";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lançar Resultados</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
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

        .btn-salvar {
            background-color: #120428;
            color: #fff;
        }

        .btn-salvar:hover {
            background-color: #2c1d59;
            color: #fff;
        }

        .form-label {
            font-weight: 600;
        }

        .resultados-lista li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
    </style>
</head>
<body>

<div class="container">
    <h1 class="text-center mb-4">Lançamento de Resultados</h1>

    <?php if (!empty($mensagem)) : ?>
        <div class="alert alert-success"><?php echo $mensagem; ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Paciente -->
        <div class="mb-3">
            <label for="paciente" class="form-label">Selecionar Paciente</label>
            <select class="form-select" name="paciente" id="paciente" required onchange="this.form.submit()">
                <option value="">-- Selecione --</option>
                <?php foreach ($pacientes as $id => $nome): ?>
                    <option value="<?= $id ?>" <?= isset($_POST['paciente']) && $_POST['paciente'] == $id ? 'selected' : '' ?>>
                        <?= htmlspecialchars($nome) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Exames do paciente -->
        <?php if (isset($_POST['paciente']) && isset($exames_agendados[$_POST['paciente']])): ?>
            <h5 class="mt-4">Exames Agendados:</h5>
            <?php foreach ($exames_agendados[$_POST['paciente']] as $index => $exame): ?>
                <div class="border rounded p-3 mb-4">
                    <h6 class="mb-3"><?= htmlspecialchars($exame) ?></h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Valor do Exame</label>
                            <input type="text" name="valor_exame[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Unidade de Medida</label>
                            <input type="text" name="unidade_medida[]" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Valor de Referência</label>
                            <input type="text" name="valor_referencia[]" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observações / Parecer</label>
                        <textarea name="observacoes[]" class="form-control" rows="2"></textarea>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Data do Resultado</label>
                    <input type="date" name="data_resultado" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Técnico Responsável</label>
                    <input type="text" name="tecnico_responsavel" class="form-control" required>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-salvar">Salvar Resultados</button>
            </div>
        <?php endif; ?>
    </form>

    <?php if (!empty($resultados)): ?>
        <div class="mt-5">
            <h4 class="mb-3">Resumo dos Resultados:</h4>
            <ul class="list-group resultados-lista">
                <?php foreach ($resultados as $res): ?>
                    <li class="list-group-item">
                        <strong><?= $res['exame'] ?>:</strong> <?= $res['valor'] ?> <?= $res['unidade'] ?> <br>
                        <small><strong>Referência:</strong> <?= $res['referencia'] ?> | <strong>Obs:</strong> <?= $res['observacoes'] ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
