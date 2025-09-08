<?php
class Paciente {
    private $id;
    private $nome;
    private $cpf;
    private $data_nascimento;
    private $email;
    private $telefone; // Campo adicionado para consistência

    public function __construct($nome = "", $cpf = "", $data_nascimento = "", $email = "", $id = null, $telefone = "") {
        $this->nome = $nome;
        $this->cpf = $cpf;
        $this->data_nascimento = $data_nascimento;
        $this->email = $email;
        $this->id = $id;
        $this->telefone = $telefone;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getCpf() { return $this->cpf; }
    public function getDataNascimento() { return $this->data_nascimento; }
    public function getEmail() { return $this->email; }
    public function getTelefone() { return $this->telefone; }

    // Setters
    public function setId($id) { $this->id = $id; }
    public function setNome($nome) { $this->nome = $nome; }
    public function setCpf($cpf) { $this->cpf = $cpf; }
    public function setDataNascimento($data_nascimento) { $this->data_nascimento = $data_nascimento; }
    public function setEmail($email) { $this->email = $email; }
    public function setTelefone($telefone) { $this->telefone = $telefone; }
}
?>