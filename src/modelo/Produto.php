<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';
require_once __DIR__.'/Obra.php';

class Produto {

        private ?int $id;
        private string $nome;
        private string $descricao;
        private float $preco;
        private int $quantidade;
        private ?string $imagem;
        private Obra $obra;

    function __construct(?int $id, string $nome, string $descricao, int $quantidade, float $preco, Obra $obra, ?string $imagem = null) {

        $this->id = $id;
        $this->imagem = $imagem ?? 'sem_imagem.png';
        $this->nome = $nome;
        $this->descricao = $descricao;
        $this->preco = $preco;
        $this->quantidade = $quantidade;
        $this->obra = $obra;

    }

    function getId() : int 
    {
        return $this->id;
    }

    function getNome() : string 
    {
        return $this->nome;
    }

    function getDescricao() : string 
    {
        return $this->descricao;
    }

    function getPreco() : float 
    {
        return $this->preco;
    }

    function getQuantidade() : int 
    {
        return $this->quantidade;
    }

    function setQuantidade(int $quantidade): void
    {
        $this->quantidade = $quantidade;
    }

    function getObra() : Obra {
        return $this->obra;
    }

    public function getImagem(): ?string 
    {
        return $this->imagem;
    }

    public function getImagemDiretorio(): string 
    {
        
        $nomeImagem = $this->imagem ?: 'semImagem.png';
        
        $caminhoUploads = DIR_PROJETOWEB . 'uploads/produtos/' . $nomeImagem;
        
        // var_dump($caminhoUploads);
        
        if (file_exists($caminhoUploads)) {
            return 'uploads/produtos/' . $nomeImagem;
        }
        
        return 'img/' . $nomeImagem;
    }

}

