<!-- filepath: c:\Users\alexa\OneDrive\Documentos\GitHub\desenvolvimentoDeSistemas\classes\Exame.php -->
<?php
class Exame {
    private $nome;
    private $pacienteId;

    public function __construct($nome, $pacienteId) {
        $this->nome = $nome;
        $this->pacienteId = $pacienteId;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getPacienteId() {
        return $this->pacienteId;
    }
}
?>