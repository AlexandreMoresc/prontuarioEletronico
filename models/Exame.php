<?php
class Exame {
    private $nome;
    private $descricao;

    public function __construct($nome, $descricao) {
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function toArray() {
        return [
            'nome' => $this->nome,
            'descricao' => $this->descricao
        ];
    }
}
?>