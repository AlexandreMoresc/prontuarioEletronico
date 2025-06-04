
public class Biomedico extends Pessoa {
    private String senha;
    private String crbm;

    public Biomedico(String nome, String email, String senha, String crbm) {
        super(nome, email);
        this.senha = senha;
        this.crbm = crbm;
    }

    public String getNome() {
         return nome; 
    }
    public String getEmail() {
         return email; 
    }
    public String getSenha() {
         return senha;
    }
    public String getCrbm() {
         return crbm; 
    }

    public void setNome(String nome) { 
        this.nome = nome; 
    }
    public void setEmail(String email) { 
        this.email = email; 
    }
    public void setSenha(String senha) { 
        this.senha = senha; 
    }
    public void setCrbm(String crbm) {
         this.crbm = crbm;
    }

    @Override
    public String gerarInsertSQL() {
        return String.format(
            "INSERT INTO usuario (nome, email, senha, crbm) VALUES ('%s', '%s', '%s', '%s');",
            nome.replace("'", "''"), email.replace("'", "''"), senha.replace("'", "''"), crbm.replace("'", "''")
        );
    }

    @Override
    public String toString() {
        return String.format("Nome: %s | Email: %s | CRBM: %s", nome, email, crbm);
    }
}