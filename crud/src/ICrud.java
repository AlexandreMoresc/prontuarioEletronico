


public interface ICrud<T> {
    void cadastrar(T obj);
    void listar();
    void editar(String chave);
    void excluir(String chave);
}
