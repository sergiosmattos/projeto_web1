<?php

class Usuario
{
    private ?int $id_usuario;
    private string $tipo_usuario;
    private string $nome_usuario;
    private DateTime $data_nascimento_usuario;
    private string $email_usuario;
    private string $senha_usuario;

    public function __construct(
        ?int $id_usuario,
        string $tipo_usuario,
        string $nome_usuario,
        DateTime $data_nascimento_usuario,
        string $email_usuario,
        string $senha_usuario
    ) {
        $this->id_usuario = $id_usuario;
        $this->tipo_usuario = $tipo_usuario;
        $this->nome_usuario = $nome_usuario;
        $this->data_nascimento_usuario = $data_nascimento_usuario;
        $this->email_usuario = $email_usuario;
        $this->senha_usuario = $senha_usuario;
    }

    
    public function getId(): ?int
    {
        return $this->id_usuario;
    }

    public function setId(?int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    public function getNome(): string
    {
        return $this->nome_usuario;
    }

    public function setNome(string $nome_usuario): void
    {
        $this->nome_usuario = $nome_usuario;
    }

    
    public function getTipo(): string
    {
        return $this->tipo_usuario;
    }

    public function setTipo(string $tipo_usuario): void
    {
        $this->tipo_usuario = $tipo_usuario;
    }

    
    public function getEmail(): string
    {
        return $this->email_usuario;
    }

    public function setEmail(string $email_usuario): void
    {
        $this->email_usuario = $email_usuario;
    }

    
    public function getSenha(): string
    {
        return $this->senha_usuario;
    }

    public function setSenha(string $senha_usuario): void
    {
        $this->senha_usuario = $senha_usuario;
    }

    
    public function getDataNascimento(): DateTime
    {
        return $this->data_nascimento_usuario;
    }

    public function setDataNascimento(DateTime $data_nascimento_usuario): void
    {
        $this->data_nascimento_usuario = $data_nascimento_usuario;
    }
}
