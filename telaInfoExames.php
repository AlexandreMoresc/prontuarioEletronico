<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Seleção de Exames por Perfil</title>
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

        .accordion-button:not(.collapsed) {
            background-color: #6a11cb;
            color: white;
        }

        .btn-salvar {
            background-color: #120428;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center mb-4">Selecionar Exames</h2>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="paciente_id" class="form-label">Paciente</label>
            <select name="paciente_id" class="form-select" required>
                <option value="" disabled selected>Selecione o paciente</option>
                <?php
                $pacientes = [
                    ['id' => 1, 'nome' => 'Maria Silva', 'cpf' => '12345678901'],
                    ['id' => 2, 'nome' => 'João Souza', 'cpf' => '98765432100']
                ];

                foreach ($pacientes as $paciente) {
                    $cpf = $paciente['cpf'];
                    $cpf_formatado = substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
                    echo "<option value='{$paciente['id']}'>{$paciente['nome']} - CPF: {$cpf_formatado}</option>";
                }
                ?>
            </select>
        </div>

        <div class="accordion mb-3" id="examesAccordion">
            <!-- Acordeões dos exames seguem iguais (sem alteração no conteúdo) -->
            <!-- ... (deixe todos os blocos como estão no seu código original) -->
            <?php
            function criarGrupoExames($titulo, $id, $exames) {
                echo "
                <div class='accordion-item'>
                    <h2 class='accordion-header' id='heading$id'>
                        <button class='accordion-button collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$id'>
                            $titulo
                        </button>
                    </h2>
                    <div id='collapse$id' class='accordion-collapse collapse' data-bs-parent='#examesAccordion'>
                        <div class='accordion-body'>";
                foreach ($exames as $exame) {
                    echo "<div class='form-check'>
                            <input class='form-check-input' type='checkbox' name='exames[]' value='$exame'>
                            <label class='form-check-label'>$exame</label>
                          </div>";
                }
                echo "      </div>
                    </div>
                </div>";
            }

            criarGrupoExames("Função Hepática", "Hepatica", ["TGO (AST)", "TGP (ALT)", "GGT", "Fosfatase Alcalina", "Bilirrubinas (Total, Direta, Indireta)", "Albumina", "Proteínas Totais e Frações"]);
            criarGrupoExames("Função Renal", "Renal", ["Ureia", "Creatinina", "Clearance de Creatinina", "Ácido Úrico"]);
            criarGrupoExames("Glicemia / Diabetes", "Glicemia", ["Glicose (jejum/pós-prandial)", "Hemoglobina Glicada (HbA1c)", "Insulina", "Peptídeo C"]);
            criarGrupoExames("Eletrólitos / Equilíbrio", "Eletrólitos", ["Sódio", "Potássio", "Cloro", "Cálcio (total/ionizado)", "Magnésio", "Fósforo"]);
            criarGrupoExames("Perfil Lipídico", "Lipidico", ["Colesterol Total", "HDL", "LDL", "VLDL", "Triglicerídeos"]);
            criarGrupoExames("Marcadores Cardíacos", "Cardiacos", ["CK (CPK)", "CK-MB", "Troponina T/I", "Mioglobina"]);
            criarGrupoExames("Função Óssea / Mineral", "Ossea", ["Fosfatase Alcalina", "Cálcio", "Fósforo", "Paratormônio (PTH)", "Vitamina D"]);
            criarGrupoExames("Inflamação e Outros", "Inflamacao", ["PCR (Proteína C Reativa)", "LDH", "Amilase", "Lipase", "Ferritina", "Transferrina", "TIBC/UIBC", "Vitamina B12", "Ácido Fólico"]);
            ?>
        </div>

        <button type="submit" class="btn btn-salvar w-100">Salvar Exames</button>
    </form>

    <?php
    include('classes/Exame.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pacienteId = $_POST['paciente_id'];
        $examesSelecionados = $_POST['exames'] ?? [];

        $exames = [];
        foreach ($examesSelecionados as $exameNome) {
            $exames[] = new Exame($exameNome, $pacienteId);
        }

        echo "<div class='mt-4 alert alert-success'>";
        echo "<strong>Exames selecionados para o paciente ID $pacienteId:</strong><ul>";
        foreach ($exames as $exame) {
            echo "<li>{$exame->getNome()}</li>";
        }
        echo "</ul></div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
