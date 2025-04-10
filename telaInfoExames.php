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

    <form method="POST" action="selecionar_exames.php">
        <div class="mb-3">
            <label for="paciente" class="form-label">Paciente</label>
            <select name="paciente" id="paciente" class="form-select" required>
                <option value="">-- Selecione o paciente --</option>
                <option value="1">João da Silva</option>
                <option value="2">Maria Oliveira</option>
            </select>
        </div>

        <div class="accordion mb-3" id="examesAccordion">

            <!-- Função Hepática -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingHepatica">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseHepatica">
                        Função Hepática
                    </button>
                </h2>
                <div id="collapseHepatica" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["TGO (AST)", "TGP (ALT)", "GGT", "Fosfatase Alcalina", "Bilirrubinas (Total, Direta, Indireta)", "Albumina", "Proteínas Totais e Frações"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Função Renal -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingRenal">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRenal">
                        Função Renal
                    </button>
                </h2>
                <div id="collapseRenal" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["Ureia", "Creatinina", "Clearance de Creatinina", "Ácido Úrico"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Glicemia / Diabetes -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingGlicemia">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGlicemia">
                        Glicemia / Diabetes
                    </button>
                </h2>
                <div id="collapseGlicemia" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["Glicose (jejum/pós-prandial)", "Hemoglobina Glicada (HbA1c)", "Insulina", "Peptídeo C"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Eletrólitos / Equilíbrio -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingEletrólitos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEletrólitos">
                        Eletrólitos / Equilíbrio
                    </button>
                </h2>
                <div id="collapseEletrólitos" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["Sódio", "Potássio", "Cloro", "Cálcio (total/ionizado)", "Magnésio", "Fósforo"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Perfil Lipídico -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingLipidico">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLipidico">
                        Perfil Lipídico
                    </button>
                </h2>
                <div id="collapseLipidico" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["Colesterol Total", "HDL", "LDL", "VLDL", "Triglicerídeos"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Marcadores Cardíacos -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingCardiacos">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCardiacos">
                        Marcadores Cardíacos
                    </button>
                </h2>
                <div id="collapseCardiacos" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["CK (CPK)", "CK-MB", "Troponina T/I", "Mioglobina"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Função Óssea / Mineral -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOssea">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOssea">
                        Função Óssea / Mineral
                    </button>
                </h2>
                <div id="collapseOssea" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["Fosfatase Alcalina", "Cálcio", "Fósforo", "Paratormônio (PTH)", "Vitamina D"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Inflamação e Outros -->
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingInflamacao">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInflamacao">
                        Inflamação e Outros
                    </button>
                </h2>
                <div id="collapseInflamacao" class="accordion-collapse collapse" data-bs-parent="#examesAccordion">
                    <div class="accordion-body">
                        <?php
                        $exames = ["PCR (Proteína C Reativa)", "LDH", "Amilase", "Lipase", "Ferritina", "Transferrina", "TIBC/UIBC", "Vitamina B12", "Ácido Fólico"];
                        foreach ($exames as $exame) {
                            echo "<div class='form-check'><input class='form-check-input' type='checkbox' name='exames[]' value='$exame'> <label class='form-check-label'>$exame</label></div>";
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>

        <button type="submit" class="btn btn-salvar w-100">Salvar Exames</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $paciente = $_POST['paciente'];
        $exames = $_POST['exames'] ?? [];

        echo "<div class='mt-4 alert alert-success'>";
        echo "<strong>Exames selecionados para o paciente ID $paciente:</strong><ul>";
        foreach ($exames as $exame) {
            echo "<li>$exame</li>";
        }
        echo "</ul></div>";
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
