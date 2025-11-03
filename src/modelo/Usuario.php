<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/projeto_web1/config.php';

class Usuario
{
    private ?int $id;
    private string $tipo;
    private string $nome;
    private DateTime $dataNascimento;
    private string $email;
    private string $senha;

    private ?string $imagem;

    public function __construct( ?int $id, ?string $tipo, string $nome, DateTime $dataNascimento, string $email, string $senha, ?string $imagem = null) {

        $this->id = $id;
        $this->tipo = $tipo ?? 'User';
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->senha = $senha;
        $this->imagem = $imagem ?? 'icon_user_branco.svg';
        
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getDataNascimento(): DateTime
    {
        return $this->dataNascimento;
    }

    public function getImagem(): ?string
    {
        return $this->imagem;
    }

    public function getImagemDiretorio(): string
    {
        $nomeImagem = $this->imagem ?: 'icon_user_branco.svg';
        
        $caminhoUploads = DIR_PROJETOWEB . 'uploads/' . $nomeImagem;
        
        if (file_exists($caminhoUploads)) {
            return 'uploads/usuarios/' . $nomeImagem;
        }

        
        return 'img/' . $nomeImagem;
    }

    
}