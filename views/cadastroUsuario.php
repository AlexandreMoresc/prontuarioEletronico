<?php
require_once(__DIR__ . '/../config/db.php');
session_start();

$mensagem = '';
$usuario = null;

// INSERIR
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadastrar_usuario'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $crbm = $_POST['crbm'];

    // Gerar o hash da senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Enviar para a API Node.js
    $data = [
        'nome' => $nome,
        'email' => $email,
        'senha' => $senhaHash, // Enviar o hash da senha
        'crbm' => $crbm
    ];
    $ch = curl_init('http://localhost:3000/api/biomedicos');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode === 201) {
        $mensagem = "Usuário cadastrado";
    } else {
        $mensagem = "Erro ao cadastrar" . htmlspecialchars($response);
    }
}

// EDITAR
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $ch = curl_init("http://localhost:3000/api/biomedicos/$id");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    $usuario = json_decode($response, true);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_usuario'])) {
    $id = intval($_POST['id']);
    $data = [
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
        'crbm' => $_POST['crbm']
    ];
    $ch = curl_init("http://localhost:3000/api/biomedicos/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode === 200) {
        $mensagem = "Usuário atualizado";
    } else {
        $mensagem = "Erro ao atualizar" . htmlspecialchars($response);
    }
}

// EXCLUIR
if (isset($_GET['excluir'])) {
    $id = intval($_GET['excluir']);
    $ch = curl_init("http://localhost:3000/api/biomedicos/$id");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpcode === 200) {
        $mensagem = "Usuário excluído";
    } else {
        $mensagem = "Erro ao excluir: " . htmlspecialchars($response);
    }
}

// LISTAR
$ch = curl_init('http://localhost:3000/api/biomedicos');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
$usuarios = json_decode($response, true) ?? [];
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <div class="container">
        <h2 class="mb-4 text-center"><?= $usuario ? 'Editar Usuário' : 'Cadastro de Usuário' ?></h2>
        <?php if ($mensagem): ?>
            <div class="alert alert-info"><?= htmlspecialchars($mensagem) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <?php include 'components/formCamposUsuario.php'; ?>
            <?php if ($usuario): ?>
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                <button type="submit" name="editar_usuario" class="btn btn-warning w-100">Salvar Alterações</button>
                <a href="cadastroUsuario.php" class="btn btn-secondary w-100 mt-2">Cancelar</a>
            <?php else: ?>
                <button type="submit" name="cadastrar_usuario" class="btn btn-primary w-100">Cadastrar</button>
                <a href="login.php" class="btn btn-success w-100 mt-2">Voltar para Login</a>
            <?php endif; ?>
        </form>
        <h3 class="mt-5 text-center">Usuários Cadastrados</h3>
        <table class="table table-striped mt-3">
           <thead>
    <tr>
        <th>Nome</th>
        <th>E-mail</th>
        <th>CRBM</th>
        <th>Ações</th>
    </tr>
</thead>
<tbody>
<?php foreach ($usuarios as $row): ?>
<tr>
    <td><?= htmlspecialchars($row['nome']) ?></td>
    <td><?= htmlspecialchars($row['email']) ?></td>
    <td><?= htmlspecialchars($row['crbm']) ?></td>
    <td>
        <a href="?editar=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
        <a href="?excluir=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Excluir usuário?')">Excluir</a>
    </td>
</tr>
<?php endforeach; ?>
</tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>