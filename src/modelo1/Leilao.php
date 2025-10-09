<?php

require __DIR__.'/Produto.php';

class Leilao {

    private ?int $id;
    private DateTime $dataHorarioInicio;
    private float $lanceInicial;
    private float $lanceAtual;
    private Produto $produtoLeiloado;
    
    public function __construct(?int $id, $dataHorarioInicio, $lanceInicial, $lanceAtual, $produtoLeiloado) {
        
        $this->id = $id;
        $this->dataHorarioInicio = $dataHorarioInicio;
        $this->lanceInicial = $lanceInicial;
        $this->lanceAtual = $lanceAtual;
        $this->produtoLeiloado = $produtoLeiloado;

    }

    function getId() : ?int {
        return $this->id;
    }

    function getDataHorarioInicio() : DateTime {
        return $this->dataHorarioInicio;
    }

    function getLanceInicial() : float {
        return $this->lanceInicial;
    }

    function getLanceAtual() : float {
        return $this->lanceAtual;
    }

    function getProdutoLeiloado() : Produto {
        return $this->produtoLeiloado;
    }

}

?>