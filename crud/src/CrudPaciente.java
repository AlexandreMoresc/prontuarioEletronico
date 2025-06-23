
import java.util.ArrayList;
import java.io.FileWriter;
import java.io.IOException;

public class CrudPaciente implements ICrud<Paciente> {
    private ArrayList<Paciente> pacientes = new ArrayList<>();

    @Override
    public void cadastrar(Paciente p) {
        pacientes.add(p);
        System.out.println("Paciente cadastrado!");
        // Escreve INSERT no arquivo
        String insert = String.format(
            "INSERT INTO paciente (nome, cpf, telefone) VALUES ('%s', '%s', '%s');",
            p.getNome().replace("'", "''"),
            p.getCpf().replace("'", "''"),
            p.getTelefone().replace("'", "''")
        );
        try (FileWriter fw = new FileWriter("inserts_paciente.sql", true)) {
            fw.write(insert + System.lineSeparator());
        } catch (IOException e) {
            System.out.println("Erro ao gravar no arquivo: " + e.getMessage());
        }
    }

    @Override
    public void listar() {
        if (pacientes.isEmpty()) System.out.println("Nenhum paciente cadastrado.");
        else for (Paciente p : pacientes) System.out.println(p);
    }

    @Override
    public void editar(String cpfBusca) {
        for (Paciente p : pacientes) {
            if (p.getCpf().equalsIgnoreCase(cpfBusca.trim())) {
                java.util.Scanner sc = new java.util.Scanner(System.in);
                System.out.print("Novo nome (" + p.getNome() + "): ");
                String nome = sc.nextLine();
                if (!nome.isEmpty()) p.setNome(nome);
                System.out.print("Novo telefone (" + p.getTelefone() + "): ");
                String tel = sc.nextLine();
                if (!tel.isEmpty()) p.setTelefone(tel);
                System.out.println("Paciente atualizado!");
                return;
            }
        }
        System.out.println("CPF não encontrado.");
    }

    @Override
    public void excluir(String cpfBusca) {
        for (Paciente p : pacientes) {
            if (p.getCpf().equalsIgnoreCase(cpfBusca.trim())) {
                pacientes.remove(p);
                System.out.println("Paciente removido!");
                return;
            }
        }
        System.out.println("CPF não encontrado.");
    }
}
