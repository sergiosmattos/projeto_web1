<?php

class Usuario
{
    private ?int $id;
    private string $tipo;
    private string $nome;
    private DateTime $dataNascimento;
    private string $email;
    private string $senha;

    public function __construct(?int $id, string $tipo, string $nome, DateTime $dataNascimento, string $email, string $senha)
    {
        $this->id = $id;
        $this->nome = $nome;
        $this->tipo = $tipo;
        $this->email = $email;
        $this->senha = $senha;
        $this->dataNascimento = $dataNascimento;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    public function getTipo(): string
    {
        return $this->tipo;
    }

    public function setModo(string $tipo): void
    {
        $this->tipo = $tipo;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    public function getDataNascimento(): DateTime
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(DateTime $dataNascimento): void
    {
        $this->dataNascimento = $dataNascimento;
    }
}
