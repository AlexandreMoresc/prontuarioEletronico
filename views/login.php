<?php
require_once(__DIR__ . '/../config/db.php');
session_start();

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $stmt = $conn->prepare("SELECT * FROM usuario WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header('Location: home.php');
        exit;
    } else {
        $erro = "E-mail ou senha inválidos!";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Biomédico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            min-height: 100vh;
        }
        .login-container {
            background: #fff;
            color: #000;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 12px rgba(0,0,0,0.3);
            max-width: 400px;
            margin: 80px auto;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2 class="mb-4 text-center">Login Biomédico</h2>
        <?php if ($erro): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
        <div class="text-center mt-3">
            <a href="cadastroUsuario.php">Não possui cadastro? Cadastre-se</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
