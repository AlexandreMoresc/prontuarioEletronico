<!-- filepath: c:\Users\alexa\OneDrive\Documentos\GitHub\desenvolvimentoDeSistemas\home.php -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Sistema de Gerenciamento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #fff;
        }

        .container {
            background: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .btn-custom {
            background-color: #120428;
            color: #fff;
            margin: 10px 0;
        }

        .btn-custom:hover {
            background-color: #2c1d59;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Bem-vindo ao Prontuário Eletrônico</h1>
        <p>Escolha uma das opções abaixo para continuar:</p>
        <div class="d-grid gap-3">
            <a href="cadastro.html" class="btn btn-custom btn-lg">Cadastro de Pacientes</a>
            <a href="telaInfoExames.php" class="btn btn-custom btn-lg">Seleção de Exames</a>
            <a href="lancamentoDeExame.php" class="btn btn-custom btn-lg">Lançamento de Resultados</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>