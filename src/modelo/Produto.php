<?php

require __DIR__.'/Obra.php';

class Produto {

        private ?int $id;
        private string $nome;
        private string $descricao;
        private float $preco;
        private Obra $obra;

    function __construct(?int $id, string $nome, string $descricao, float $preco, Obra $obra) {

        $this->$id = $id;
        $this->$nome = $nome;
        $this->$descricao = $descricao;
        $this->$preco = $preco;
        $this->$obra = $obra;

    }

    function getId() : int {
        return $this->id;
    }

    function getNome() : string {
        return $this->nome;
    }

    function getDescricao() : string {
        return $this->descricao;
    }

    function getPreco() : float {
        return $this->preco;
    }

    function getObra() : Obra {
        return $this->obra;
    }

}

