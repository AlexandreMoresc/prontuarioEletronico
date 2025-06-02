<?php
class Usuario {
    private $nome;
    private $email;
    private $senha;

    public function __construct($nome, $email, $senha) {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function toArray() {
        return [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ];
    }
}
?>