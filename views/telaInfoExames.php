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

<?php
require_once(__DIR__ . '/../controllers/ExameController.php');
ExameController::cadastrar();
$exames = ExameController::listar();
include 'navbar.php';
?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Cadastro de Exames</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome do Exame:</label>
            <input type="text" class="form-control" id="nome" name="nome" required>
        </div>
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição:</label>
            <textarea class="form-control" id="descricao" name="descricao"></textarea>
        </div>
        <button type="submit" name="cadastrar_exame" class="btn btn-primary">Cadastrar</button>
    </form>
    <h2 class="text-center mt-5">Exames Cadastrados</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $exames->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nome']) ?></td>
                <td><?= htmlspecialchars($row['descricao']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
