import java.io.FileWriter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Scanner;

public class GerenciadorBiomedico implements ICrud {
    private ArrayList<Biomedico> biomedicos = new ArrayList<>();

    @Override
    public void inserir() {
        Scanner sc = new Scanner(System.in);
        System.out.print("Nome: ");
        String nome = sc.nextLine();
        System.out.print("Email: ");
        String email = sc.nextLine();
        System.out.print("Senha: ");
        String senha = sc.nextLine();
        System.out.print("CRBM: ");
        String crbm = sc.nextLine();

        Biomedico b = new Biomedico(nome, email, senha, crbm);
        biomedicos.add(b);
        salvarInsertSQL(b);
        System.out.println("Biomédico cadastrado e comando SQL salvo!");
    }

    @Override
    public void listar() {
        if (biomedicos.isEmpty()) {
            System.out.println("Nenhum biomédico cadastrado.");
        } else {
            for (Biomedico b : biomedicos) {
                System.out.println("CRBM: " + b.getCrbm() + " - " + b);
            }
        }
    }

    @Override
    public void editar() {
        listar();
        if (biomedicos.isEmpty()) return;
        Scanner sc = new Scanner(System.in);
        System.out.print("Digite o CRBM do biomédico para editar: ");
        String crbmBusca = sc.nextLine();
        Biomedico b = null;
        for (Biomedico bio : biomedicos) {
            if (bio.getCrbm().equalsIgnoreCase(crbmBusca.trim())) {
                b = bio;
                break;
            }
        }
        if (b != null) {
            System.out.print("Novo nome (" + b.getNome() + "): ");
            String nome = sc.nextLine();
            if (!nome.isEmpty()) b.setNome(nome);
            System.out.print("Novo email (" + b.getEmail() + "): ");
            String email = sc.nextLine();
            if (!email.isEmpty()) b.setEmail(email);
            System.out.print("Nova senha: ");
            String senha = sc.nextLine();
            if (!senha.isEmpty()) b.setSenha(senha);
            System.out.print("Novo CRBM (" + b.getCrbm() + "): ");
            String crbmNovo = sc.nextLine();
            if (!crbmNovo.isEmpty()) b.setCrbm(crbmNovo);
            System.out.println("Biomédico atualizado!");
        } else {
            System.out.println("CRBM não encontrado.");
        }
    }

    private void salvarInsertSQL(Biomedico b) {
        try (FileWriter fw = new FileWriter("inserts_usuario.sql", true)) {
            fw.write(b.gerarInsertSQL() + "\n");
        } catch (IOException e) {
            System.out.println("Erro ao salvar SQL: " + e.getMessage());
        }
    }

    public static void main(String[] args) {
        GerenciadorBiomedico gb = new GerenciadorBiomedico();
        Scanner sc = new Scanner(System.in);
        int op;
        do {
            System.out.println("\n1-Inserir 2-Listar 3-Editar 0-Sair");
            op = sc.nextInt();
            sc.nextLine();
            switch (op) {
                case 1: gb.inserir(); break;
                case 2: gb.listar(); break;
                case 3: gb.editar(); break;
            }
        } while (op != 0);
        System.out.println("Fim do programa.");
    }
}
