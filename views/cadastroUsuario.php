<?php
require_once(__DIR__ . '/../config/db.php');
include 'navbar.php';
session_start();

$mensagem = '';
$usuario = null;

// INSERIR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_usuario'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nome, $email, $senha);
    if ($stmt->execute()) {
        $mensagem = "Usuário cadastrado!";
    } else {
        $mensagem = "Erro ao cadastrar!";
    }
    $stmt->close();
}

// EDITAR
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM usuario WHERE id = $id");
    $usuario = $res->fetch_assoc();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_usuario'])) {
    $id = intval($_POST['id']);
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;
    if ($senha) {
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, email=?, senha=? WHERE id=?");
        $stmt->bind_param("sssi", $nome, $email, $senha, $id);
    } else {
        $stmt = $conn->prepare("UPDATE usuario SET nome=?, email=? WHERE id=?");
        $stmt->bind_param("ssi", $nome, $email, $id);
    }
    if ($stmt->execute()) {
        $mensagem = "Usuário atualizado!";
    } else {
        $mensagem = "Erro ao atualizar!";
    }
    $stmt->close();
    $usuario = null;
}

// EXCLUIR
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $conn->query("DELETE FROM usuario WHERE id = $id");
    $mensagem = "Usuário excluído!";
}

// LISTAR
$usuarios = $conn->query("SELECT * FROM usuario ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(to right, #6a11cb, #2575fc); min-height: 100vh; }
        .container { background: #fff; color: #000; padding: 30px; border-radius: 10px; box-shadow: 0 0 12px rgba(0,0,0,0.3); max-width: 600px; margin: 60px auto; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= $usuario ? 'Editar Usuário' : 'Cadastro de Usuário' ?></h2>
        <?php if ($mensagem): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <?php include 'formCamposUsuario.php'; ?>
            <?php if ($usuario): ?>
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                <button type="submit" name="editar_usuario" class="btn btn-warning w-100">Salvar Alterações</button>
                <a href="cadastroUsuario.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="cadastrar_usuario" class="btn btn-primary w-100">Cadastrar</button>
            <?php endif; ?>
        </form>
        <h3 class="mt-5 text-center">Usuários Cadastrados</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $usuarios->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['nome']) ?></td>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td>
                        <a href="?editar=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir usuário?')">Excluir</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>