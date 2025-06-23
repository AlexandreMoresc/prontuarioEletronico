
import java.util.ArrayList;
import java.io.FileWriter;
import java.io.IOException;

public class CrudExame implements ICrud<Exame> {
    private ArrayList<Exame> exames = new ArrayList<>();

    @Override
    public void cadastrar(Exame e) {
        exames.add(e);
        System.out.println("Exame cadastrado!");
        // Escreve INSERT no arquivo
        String insert = String.format(
            "INSERT INTO exame (nome, descricao) VALUES ('%s', '%s');",
            e.getNome().replace("'", "''"),
            e.getDescricao().replace("'", "''")
        );
        try (FileWriter fw = new FileWriter("inserts_exame.sql", true)) {
            fw.write(insert + System.lineSeparator());
        } catch (IOException ex) {
            System.out.println("Erro ao gravar no arquivo: " + ex.getMessage());
        }
    }

    @Override
    public void listar() {
        if (exames.isEmpty()) System.out.println("Nenhum exame cadastrado.");
        else for (Exame e : exames) System.out.println(e);
    }

    @Override
    public void editar(String nomeBusca) {
        for (Exame e : exames) {
            if (e.getNome().equalsIgnoreCase(nomeBusca.trim())) {
                java.util.Scanner sc = new java.util.Scanner(System.in);
                System.out.print("Novo nome (" + e.getNome() + "): ");
                String nome = sc.nextLine();
                if (!nome.isEmpty()) e.setNome(nome);
                System.out.print("Nova descrição (" + e.getDescricao() + "): ");
                String desc = sc.nextLine();
                if (!desc.isEmpty()) e.setDescricao(desc);
                System.out.println("Exame atualizado!");
                return;
            }
        }
        System.out.println("Exame não encontrado.");
    }

    @Override
    public void excluir(String nomeBusca) {
        for (Exame e : exames) {
            if (e.getNome().equalsIgnoreCase(nomeBusca.trim())) {
                exames.remove(e);
                System.out.println("Exame removido!");
                return;
            }
        }
        System.out.println("Exame não encontrado.");
    }
}
