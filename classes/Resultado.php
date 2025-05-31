
<?php
class Resultado {
    private $exame;
    private $valor;
    private $unidade;
    private $referencia;
    private $observacoes;
    private $dataResultado;
    private $tecnicoResponsavel;

    public function __construct($exame, $valor, $unidade, $referencia, $observacoes, $dataResultado, $tecnicoResponsavel) {
        $this->exame = $exame;
        $this->valor = $valor;
        $this->unidade = $unidade;
        $this->referencia = $referencia;
        $this->observacoes = $observacoes;
        $this->dataResultado = $dataResultado;
        $this->tecnicoResponsavel = $tecnicoResponsavel;
    }

    public function getExame() {
        return $this->exame;
    }

    public function getValor() {
        return $this->valor;
    }
}
?>