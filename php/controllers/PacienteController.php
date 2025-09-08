<?php
require_once __DIR__ . '/../dao/PacienteApiDao.php';
require_once __DIR__ . '/../models/Paciente.php';

if (isset($_POST['cadastrar'])) { // Mudança de 'salvar_paciente' para 'cadastrar' para corresponder ao form
    $pacienteDao = new PacienteApiDao();

    $novoPaciente = new Paciente(
        $_POST['nome'],
        $_POST['cpf'],
        $_POST['nascimento'], // O form usa 'nascimento'
        $_POST['email']
    );

    $sucesso = $pacienteDao->criar($novoPaciente);

    if ($sucesso) {
        header("Location: ../views/cadastroPacientes.php?msg=cadastrado_sucesso");
    } else {
       header("Location: ../views/cadastroPacientes.php?msg=erro_cadastrar");
    }
    exit();

} elseif (isset($_POST['editar'])) { // Mudança de 'atualizar_paciente' para 'editar'
    $pacienteDao = new PacienteApiDao();

    $pacienteAtualizado = new Paciente(
        $_POST['nome'],
        $_POST['cpf'],
        $_POST['nascimento'],
        $_POST['email'],
        (int)$_POST['id']
    );

    $sucesso = $pacienteDao->atualizar($pacienteAtualizado);

    if ($sucesso) {
        header("Location: ../views/cadastroPacientes.php?msg=atualizado_sucesso");
    } else {
        header("Location: ../views/cadastroPacientes.php?msg=erro_atualizar");
    }
    exit();

} elseif (isset($_GET['excluir'])) { // Mudança para corresponder ao link da view
    $pacienteDao = new PacienteApiDao();
    $id = (int)$_GET['excluir'];
    $sucesso = $pacienteDao->excluir($id);

    if ($sucesso) {
        header("Location: ../views/cadastroPacientes.php?msg=excluido_sucesso");
    } else {
        header("Location: ../views/cadastroPacientes.php?msg=erro_excluir");
    }
    exit();
}

function listarPacientesApi() {
    $pacienteApiDao = new PacienteApiDao();
    $listaDePacientes = $pacienteApiDao->read();

    if (empty($listaDePacientes)) {
        echo "<tr><td colspan='6' class='text-center'>Nenhum paciente retornado pela API. Verifique se a API está rodando.</td></tr>";
        return;
    }

    foreach ($listaDePacientes as $paciente) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($paciente->getNome()) . "</td>";
        // Formata a data para o padrão brasileiro
        $dataNasc = htmlspecialchars($paciente->getDataNascimento());
        $dataNascFormatada = $dataNasc ? date('d/m/Y', strtotime($dataNasc)) : '';
        echo "<td>" . $dataNascFormatada . "</td>";
        echo "<td>" . htmlspecialchars($paciente->getCpf()) . "</td>";
        echo "<td>" . htmlspecialchars($paciente->getTelefone()) . "</td>";
        echo "<td>" . htmlspecialchars($paciente->getEmail()) . "</td>";
        echo "<td>
                <a href='?editar=" . htmlspecialchars($paciente->getId()) . "' class='btn btn-warning btn-sm' title='Editar'> 
                    <i class='bi bi-pencil'></i>
                </a>
                <a href='../controllers/PacienteController.php?excluir=" . htmlspecialchars($paciente->getId()) . "' class='btn btn-danger btn-sm' title='Excluir' onclick='return confirm(\"Excluir paciente?\")'>
                    <i class='bi bi-trash'></i>
                </a>
              </td>";
        echo "</tr>";
    }
}
?>