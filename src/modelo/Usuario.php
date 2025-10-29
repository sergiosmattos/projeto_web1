<?php

class Usuario
{
    private ?int $id;
    private string $tipo;
    private string $nome;
    private DateTime $dataNascimento;
    private string $email;
    private string $senha;

    public function __construct( ?int $id, ?string $tipo, string $nome, DateTime $dataNascimento, string $email, string $senha) {

        $this->id = $id;
        $this->tipo = $tipo ?? 'User';
        $this->nome = $nome;
        $this->dataNascimento = $dataNascimento;
        $this->email = $email;
        $this->senha = $senha;
        
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
    
}