<?php

require __DIR__.'/Categoria.php';
class Obra
{
    private ?int $id;
    private string $nome;
    private string $descricao;
    

    public function __construct(?int $id, string $nome, string $descricao) {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getDescricao(): string
    {
        return $this->descricao;
    }
}