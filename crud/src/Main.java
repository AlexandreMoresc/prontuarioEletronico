
import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        CrudPaciente crudPaciente = new CrudPaciente();
        CrudExame crudExame = new CrudExame();
        Scanner sc = new Scanner(System.in);
        int op;
        do {
            System.out.println("\n1-Cad. Paciente 2-Listar Pacientes 3-Editar Paciente 4-Excluir Paciente");
            System.out.println("5-Cad. Exame 6-Listar Exames 7-Editar Exame 8-Excluir Exame 0-Sair");
            op = sc.nextInt(); sc.nextLine();
            switch (op) {
                case 1:
                    System.out.print("Nome: "); String nome = sc.nextLine();
                    System.out.print("CPF: "); String cpf = sc.nextLine();
                    System.out.print("Telefone: "); String tel = sc.nextLine();
                    crudPaciente.cadastrar(new Paciente(nome, cpf, tel));
                    break;
                case 2: crudPaciente.listar();
                 break;
                case 3:
                    System.out.print("CPF do paciente para editar: ");
                    crudPaciente.editar(sc.nextLine());
                    break;
                case 4:
                    System.out.print("CPF do paciente para excluir: ");
                    crudPaciente.excluir(sc.nextLine());
                    break;
                case 5:
                    System.out.print("Nome do exame: "); String nomeEx = sc.nextLine();
                    System.out.print("Descrição: "); String desc = sc.nextLine();
                    crudExame.cadastrar(new Exame(nomeEx, desc));
                    break;
                case 6: crudExame.listar(); break;
                case 7:
                    System.out.print("Nome do exame para editar: ");
                    crudExame.editar(sc.nextLine());
                    break;
                case 8:
                    System.out.print("Nome do exame para excluir: ");
                    crudExame.excluir(sc.nextLine());
                    break;
            }
        } while (op != 0);
        System.out.println("Fim do programa.");
    }
}