
<!-- filepath: c:\Users\alexa\OneDrive\Documentos\GitHub\desenvolvimentoDeSistemas\home.php -->

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistema de Gerenciamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
    <h1 class="mb-4">Bem-vindo ao Prontuário Eletrônico</h1>
    <p>Escolha uma das opções abaixo para continuar:</p>
    <div class="d-grid gap-3">
        <a href="novaRequisicao.php" class="btn btn-custom btn-lg">Nova Requisição</a>
        <a href="lancamentoDeExame.php" class="btn btn-custom btn-lg">Lançamento de Resultados</a>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>